import os
import pandas as pd
from sklearn.cluster import KMeans
from sklearn.preprocessing import StandardScaler
from joblib import dump, load
from dotenv import load_dotenv
from sqlalchemy import create_engine

load_dotenv()

# DB connection info from your .env file
db_user = os.getenv('DB_USERNAME', 'root')
db_pass = os.getenv('DB_PASSWORD', '')
db_name = os.getenv('DB_DATABASE', 'terravin')
db_host = os.getenv('DB_HOST', '127.0.0.1')
db_port = os.getenv('DB_PORT', '3306')

engine = create_engine(f"mysql+pymysql://{db_user}:{db_pass}@{db_host}:{db_port}/{db_name}")

# === Model directory always next to this script ===
MODEL_DIR = os.path.join(os.path.dirname(__file__), "models")

# === Load static dataset from CSV for training ===
def load_training_data(csv_path='cleaned_wine_catalog.csv'):
    if not os.path.exists(csv_path):
        raise FileNotFoundError(f"Training dataset not found at {csv_path}")
    df = pd.read_csv(csv_path, parse_dates=['DATE'])
    df['CATEGORY'] = df['CATEGORY'].str.lower()
    return df

# === Load live data from DB for real-time use ===
def load_live_data():
    query = '''
        SELECT
            o.user_id AS customer_id,
            o.created_at AS order_date,
            oi.quantity,
            oi.unit_price,
            i.category,
            i.name AS item_name,
            COALESCE(i.images, 'default.jpg') AS item_image
        FROM order_items oi
        JOIN orders o ON oi.order_id = o.id
        JOIN inventories i ON oi.inventory_id = i.id
    '''
    df = pd.read_sql(query, engine)
    df['order_date'] = pd.to_datetime(df['order_date'])
    df['category'] = df['category'].str.lower()
    return df

# === Train and save spending model from static dataset ===
def train_spending_model(df):
    spending = df.groupby('CUSTOMER ID').agg({
        'QUANTITY': 'sum',
        'PRICE PER UNIT': lambda x: (x * df.loc[x.index, 'QUANTITY']).sum()
    }).reset_index()
    spending.columns = ['CUSTOMER ID', 'total_quantity', 'total_spent']

    # Use 'DATE' for training data
    order_counts = df.groupby('CUSTOMER ID')['DATE'].nunique().reset_index()
    order_counts.columns = ['CUSTOMER ID', 'order_frequency']
    spending = spending.merge(order_counts, on='CUSTOMER ID')

    spending['spending_per_order'] = spending['total_spent'] / spending['order_frequency']
    features = spending[['total_spent', 'order_frequency', 'spending_per_order']].dropna()

    scaler = StandardScaler()
    features_scaled = scaler.fit_transform(features)

    kmeans = KMeans(n_clusters=3, random_state=42)
    kmeans.fit(features_scaled)

    os.makedirs(MODEL_DIR, exist_ok=True)
    dump(kmeans, os.path.join(MODEL_DIR, "spending_segment_model.pkl"))
    dump(scaler, os.path.join(MODEL_DIR, "spending_scaler.pkl"))
    print("✅ Spending segmentation model trained and saved.")

# === Train and save preference model from static dataset ===
def train_preference_model(df):
    pref = df.groupby(['CUSTOMER ID', 'CATEGORY'])['QUANTITY'].sum().reset_index()
    matrix = pref.pivot(index='CUSTOMER ID', columns='CATEGORY', values='QUANTITY').fillna(0)

    if len(matrix) < 2:
        print("❌ Not enough data for preference clustering.")
        return

    norm_matrix = matrix.div(matrix.sum(axis=1), axis=0).fillna(0)
    kmeans = KMeans(n_clusters=3, random_state=42)
    kmeans.fit(norm_matrix)

    os.makedirs(MODEL_DIR, exist_ok=True)
    dump(kmeans, os.path.join(MODEL_DIR, "preference_segment_model.pkl"))
    print("✅ Preference segmentation model trained and saved.")

# === Train models once from CSV dataset, only if not already trained ===
def train_models_from_dataset(csv_path='cleaned_wine_catalog.csv'):
    model_path1 = os.path.join(MODEL_DIR, "spending_segment_model.pkl")
    model_path2 = os.path.join(MODEL_DIR, "preference_segment_model.pkl")
    scaler_path = os.path.join(MODEL_DIR, "spending_scaler.pkl")

    if not (os.path.exists(model_path1) and os.path.exists(model_path2) and os.path.exists(scaler_path)):
        print(f"📊 Training models from dataset: {csv_path}")
        df_train = load_training_data(csv_path)
        train_spending_model(df_train)
        train_preference_model(df_train)
        print("✅ Training complete and models saved.")
    else:
        print("✅ Models already exist. Skipping training.")

# === Load saved models (fail if missing) ===
def load_spending_model_and_scaler():
    kmeans = load(os.path.join(MODEL_DIR, "spending_segment_model.pkl"))
    scaler = load(os.path.join(MODEL_DIR, "spending_scaler.pkl"))
    return kmeans, scaler

def load_preference_model():
    kmeans = load(os.path.join(MODEL_DIR, "preference_segment_model.pkl"))
    return kmeans

# === Segment spending behavior on live data using saved models ===
def segment_spending_behavior(df_live):
    kmeans, scaler = load_spending_model_and_scaler()

    spending = df_live.groupby('customer_id').agg({
        'quantity': 'sum',
        'unit_price': lambda x: (x * df_live.loc[x.index, 'quantity']).sum()
    }).reset_index()
    spending.columns = ['customer_id', 'total_quantity', 'total_spent']

    order_counts = df_live.groupby('customer_id')['order_date'].nunique().reset_index()
    order_counts.columns = ['customer_id', 'order_frequency']
    spending = spending.merge(order_counts, on='customer_id')

    spending['spending_per_order'] = spending['total_spent'] / spending['order_frequency']
    features = spending[['total_spent', 'order_frequency', 'spending_per_order']].dropna()

    features_scaled = scaler.transform(features)
    spending['spending_segment'] = kmeans.predict(features_scaled)

    # Map numeric segments to labels
    segment_labels = ['Low Spender', 'Medium Spender', 'High Spender']
    spending['spending_segment_label'] = spending['spending_segment'].map(lambda x: segment_labels[x] if x < len(segment_labels) else f'Segment {x}')

    return spending

# === Segment wine preference on live data using saved model ===
def segment_wine_preference(df_live):
    kmeans = load_preference_model()

    pref = df_live.groupby(['customer_id', 'category'])['quantity'].sum().reset_index()
    matrix = pref.pivot(index='customer_id', columns='category', values='quantity').fillna(0)
    if len(matrix) < 2:
        return pd.DataFrame(columns=['customer_id', 'preference_segment', 'preference_segment_label'])

    norm_matrix = matrix.div(matrix.sum(axis=1), axis=0).fillna(0)
    matrix['preference_segment'] = kmeans.predict(norm_matrix)
    # Map numeric segments to labels
    segment_labels = ['Red Wine Lover', 'White Wine Lover', 'Mixed Preference']
    matrix['preference_segment_label'] = matrix['preference_segment'].map(lambda x: segment_labels[x] if x < len(segment_labels) else f'Preference {x}')
    return matrix.reset_index()[['customer_id', 'preference_segment', 'preference_segment_label']]

# === Recommendation logic ===
def recommend_wines(user_id, current_month, df_live, min_recs=30):
    if 'month' not in df_live.columns:
        df_live['month'] = pd.to_datetime(df_live['order_date']).dt.month
    user_data = df_live[df_live['customer_id'] == user_id]

    if user_data.empty:
        monthly_wines = df_live[df_live['month'] == current_month]
        return monthly_wines.sample(n=min(min_recs, len(monthly_wines))) if not monthly_wines.empty else pd.DataFrame()

    category = user_data['category'].mode().iloc[0] if not user_data['category'].empty else 'red wine'
    avg_spend = (user_data['quantity'] * user_data['unit_price']).mean()
    price_range = (avg_spend * 0.8, avg_spend * 1.2)

    seasonal_map = {
        'red wine': [11, 12, 4, 2],
        'white wine': [1, 5, 9, 10],
        'sparkling wine': [3, 6, 7, 8]
    }
    seasonal_cats = [cat for cat, months in seasonal_map.items() if current_month in months]

    recommendations = df_live[(df_live['category'] == category) & (df_live['unit_price'].between(*price_range))]

    if category not in seasonal_cats:
        seasonal = df_live[(df_live['category'].isin(seasonal_cats)) & (df_live['unit_price'].between(*price_range))]        
        recommendations = pd.concat([recommendations, seasonal])

    if len(recommendations) < min_recs:
        wider_price_range = (avg_spend * 0.5, avg_spend * 1.5)
        expanded = df_live[(df_live['category'] == category) & (df_live['unit_price'].between(*wider_price_range))]
        recommendations = pd.concat([recommendations, expanded])

    if len(recommendations) < min_recs:
        popular_month = df_live[df_live['month'] == current_month]
        recommendations = pd.concat([recommendations, popular_month])

    recommendations = recommendations.drop_duplicates()
    n = min(len(recommendations), min_recs)
    return recommendations.sample(n=n)

# === Manual test ===
if __name__ == "__main__":
    # Step 1: Train once from your dataset file (skip if already trained)
    train_models_from_dataset('cleaned_wine_catalog.csv')

    # Step 2: Load live data from DB
    df_live = load_live_data()

    # Step 3: Use models on live data
    spending_segments = segment_spending_behavior(df_live)
    preference_segments = segment_wine_preference(df_live)

    # Step 4: Recommend wines for a customer and month
    customer_id = "C84854"
    current_month = 7
    recs = recommend_wines(customer_id, current_month, df_live)

    print("\nSpending segments sample:\n", spending_segments.head())
    print("\nPreference segments sample:\n", preference_segments.head())
    print(f"\nRecommended wines for customer {customer_id} (Month {current_month}):")
    print(recs[['item_name', 'category', 'unit_price']])
