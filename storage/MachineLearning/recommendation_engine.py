import pandas as pd

# === Step 1: Load Preprocessed Data ===
def load_data(filepath):
    df = pd.read_csv(filepath)
    return df

# === Step 2: Generate Customer Profiles ===
def generate_customer_profiles(df):
    profiles = df.groupby('CUSTOMER ID').agg({
        'CATEGORY': lambda x: x.mode()[0],
        'PRICE PER UNIT': 'mean',
        'MONTH': lambda x: list(x.value_counts().index[:3])
    }).rename(columns={
        'CATEGORY': 'MOST FREQUENT CATEGORY',
        'PRICE PER UNIT': 'AVG SPEND',
        'MONTH': 'TOP MONTHS'
    }).reset_index()
    return profiles

# === Step 3: Recommendation Engine with min 30 products ===
def recommend_wines(customer_id, current_month, df, profiles, min_recs=30):
    profile = profiles[profiles['CUSTOMER ID'] == customer_id]

    if profile.empty:
        # Fallback: recommend popular wines this month
        monthly_wines = df[df['MONTH'] == current_month]
        if monthly_wines.empty:
            return pd.DataFrame()
        return monthly_wines.sample(n=min(min_recs, len(monthly_wines)))

    category = profile['MOST FREQUENT CATEGORY'].values[0]
    avg_spend = profile['AVG SPEND'].values[0]
    price_range = (avg_spend * 0.8, avg_spend * 1.2)

    seasonal_map = {
        'red wine': [11, 12, 4, 2],
        'white wine': [1, 5, 9, 10],
        'sparkling wine': [3, 6, 7, 8]
    }
    seasonal_cats = [cat for cat, months in seasonal_map.items() if current_month in months]

    # Step 1: Strict match on category and price range
    recommendations = df[
        (df['CATEGORY'] == category) &
        (df['PRICE PER UNIT'].between(*price_range))
    ]

    # Step 2: Add seasonal wines if customer's category not seasonal now
    if category not in seasonal_cats:
        seasonal = df[
            (df['CATEGORY'].isin(seasonal_cats)) &
            (df['PRICE PER UNIT'].between(*price_range))
        ]
        recommendations = pd.concat([recommendations, seasonal])

    recommendations = recommendations.drop_duplicates()

    # Step 3: Expand with same category, wider price range (+/- 50%)
    if len(recommendations) < min_recs:
        wider_price_range = (avg_spend * 0.5, avg_spend * 1.5)
        expanded = df[
            (df['CATEGORY'] == category) &
            (df['PRICE PER UNIT'].between(*wider_price_range))
        ]
        recommendations = pd.concat([recommendations, expanded])

    recommendations = recommendations.drop_duplicates()

    # Step 4: Add popular wines from current month regardless of category/price
    if len(recommendations) < min_recs:
        popular_month = df[df['MONTH'] == current_month]
        recommendations = pd.concat([recommendations, popular_month])

    recommendations = recommendations.drop_duplicates()

    # Final sample of at least min_recs or maximum possible
    n = min(len(recommendations), min_recs)
    return recommendations.sample(n=n)


# === Main Execution ===
if __name__ == "__main__":
    df = load_data("cleaned_wine_catalog.csv")
    profiles = generate_customer_profiles(df)

    customer_id = "C84854"
    current_month = 7  # July

    recs = recommend_wines(customer_id, current_month, df, profiles, min_recs=30)

    print(f"\n📦 Recommended wines for customer {customer_id} (Month {current_month}):")
    print(recs[['WINE NAME', 'CATEGORY', 'PRICE PER UNIT']])


     # Test 1: Known customer
    customer_id = "C84854"
    current_month = 7
    recs = recommend_wines(customer_id, current_month, df, profiles, min_recs=30)
    print(f"Recommendations for known customer {customer_id}:")
    print(recs[['WINE NAME', 'CATEGORY', 'PRICE PER UNIT']])
    print(f"Total: {len(recs)}\n")
    

    # Test 2: Unknown customer
    unknown_customer = "UNKNOWN_ID"
    recs_unknown = recommend_wines(unknown_customer, current_month, df, profiles, min_recs=30)
    print(f"Recommendations for unknown customer {unknown_customer}: {len(recs_unknown)} items\n")

