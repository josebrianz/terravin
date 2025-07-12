import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
from sklearn.ensemble import RandomForestRegressor
from sklearn.metrics import mean_squared_error, r2_score, mean_absolute_error
import joblib
# === CONFIGURATION ===
INPUT_CSV_FILE = "newest_sales.csv" # Using sales.csv as it's the more comprehensive file provided
MODEL_FILENAME = "sales_forecast_model.joblib"
MAX_PREDICTIVE_LAG = 12 # Use lags up to 12 months for better seasonality capture
ROLLING_MEAN_WINDOW = 3 # Window for rolling mean feature (can be adjusted)
FORECAST_MONTHS = 5 # As requested by the user
FORECAST_CSV_5_MONTHS = "forecast_5_months_per_category.csv" # Output file for 5-month forecast

# === Step 1: Load and Clean the Dataset ===
print("--- Step 1: Loading and Cleaning Data ---")
try:
    df = pd.read_csv(INPUT_CSV_FILE)
except FileNotFoundError:
    print(f"Error: The file '{INPUT_CSV_FILE}' was not found. Please ensure it's uploaded.")
    exit()

# Fill missing sales values with 0
for col in ['RETAIL SALES', 'RETAIL TRANSFERS', 'WAREHOUSE SALES']:
    if col in df.columns:
        df[col] = df[col].fillna(0)
    else:
        print(f"Warning: Column '{col}' not found in the dataset. Skipping fillna for this column.")

# Calculate QUANTITY as the sum of RETAIL TRANSFERS and WAREHOUSE SALES
df['QUANTITY'] = df['RETAIL TRANSFERS'] + df['WAREHOUSE SALES']

# Create a datetime column from YEAR and MONTH
# Explicitly convert YEAR and MONTH to numeric types, coercing errors
if 'YEAR' in df.columns and 'MONTH' in df.columns:
    df['YEAR'] = pd.to_numeric(df['YEAR'], errors='coerce')
    df['MONTH'] = pd.to_numeric(df['MONTH'], errors='coerce')
    # Drop rows where YEAR or MONTH became NaN due to coercion (bad data)
    df.dropna(subset=['YEAR', 'MONTH'], inplace=True)
    # Convert YEAR and MONTH back to integer after dropping NaNs
    df['YEAR'] = df['YEAR'].astype(int)
    df['MONTH'] = df['MONTH'].astype(int)
    df['DATE'] = pd.to_datetime(df[['YEAR', 'MONTH']].assign(DAY=1))
else:
    print("Error: 'YEAR' or 'MONTH' columns not found. Cannot create 'DATE' column. Exiting.")
    exit()

# Add cyclical features for MONTH (important for seasonality)
df['MONTH_SIN'] = np.sin(2 * np.pi * df['MONTH'] / 12)
df['MONTH_COS'] = np.cos(2 * np.pi * df['MONTH'] / 12)

print(f"Initial data shape after cleaning: {df.shape}")

# === Step 2: Select a Category to Forecast ===
# 🟢 IMPORTANT: Change this category name to the one you want to forecast (e.g., "BEER", "LIQUOR").
selected_category = "WINE" # Can be changed by the user
if 'CATEGORY' not in df.columns:
    print("Error: 'CATEGORY' column not found in the dataset. Cannot filter by category. Exiting.")
    exit()

df_cat = df[df['CATEGORY'].str.upper() == selected_category.upper()].copy() # Use .copy() to avoid SettingWithCopyWarning

# Check if data exists for the selected category
if df_cat.empty:
    print(f"No data found for the category: '{selected_category}'. Trying to find an alternative category.")
    # Attempt to use the first available category if the selected_category is not found
    if not df['CATEGORY'].empty:
        # Get the first non-NaN category and ensure it's uppercase for comparison
        first_category = df['CATEGORY'].dropna().iloc[0]
        print(f"Attempting to use the first available category: '{first_category}' for demonstration.")
        selected_category = first_category # Update selected_category to the found one
        df_cat = df[df['CATEGORY'].str.upper() == selected_category.upper()].copy()
        if df_cat.empty:
            print("Still no data after attempting first category. Exiting.")
            exit()
    else:
        print("No categories found in the dataset. Exiting.")
        exit()

print(f"Data shape for selected category '{selected_category}': {df_cat.shape}")

# === Step 3: Group Monthly Sales for the Selected Category ===
print("--- Step 3: Grouping Monthly Sales ---")
# Aggregate RETAIL TRANSFERS, WAREHOUSE SALES, and QUANTITY by month for the selected category.
# Also, include month_sin and month_cos as they are consistent for a given month.
monthly = df_cat.groupby('DATE').agg(
    QUANTITY=('QUANTITY', 'sum'),
    RETAIL_TRANSFERS=('RETAIL TRANSFERS', 'sum'),
    WAREHOUSE_SALES=('WAREHOUSE SALES', 'sum'),
    MONTH_SIN=('MONTH_SIN', 'mean'), # Take mean as it should be constant for a given month
    MONTH_COS=('MONTH_COS', 'mean') # Take mean as it should be constant for a given month
).reset_index()
monthly = monthly.sort_values('DATE')

print(f"Monthly aggregated data shape: {monthly.shape}")

# === Step 4: Create Lag Features and Rolling Mean ===
print("--- Step 4: Creating Lag Features and Rolling Mean ---")
# Create lagged quantity features
for lag in range(1, MAX_PREDICTIVE_LAG + 1):
    monthly[f'QUANTITY_LAG_{lag}'] = monthly['QUANTITY'].shift(lag)
    # Also add lags for RETAIL_TRANSFERS and WAREHOUSE_SALES
    monthly[f'RETAIL_TRANSFERS_LAG_{lag}'] = monthly['RETAIL_TRANSFERS'].shift(lag)
    monthly[f'WAREHOUSE_SALES_LAG_{lag}'] = monthly['WAREHOUSE_SALES'].shift(lag)

# Create rolling mean feature for QUANTITY
monthly[f'QUANTITY_ROLLING_MEAN_{ROLLING_MEAN_WINDOW}M'] = \
    monthly['QUANTITY'].rolling(window=ROLLING_MEAN_WINDOW).mean()

# Remove rows that have NaN values due to lagging or rolling operations (initial rows).
monthly.dropna(inplace=True)

# Check if enough data remains after dropping NaNs for training
if monthly.empty:
    print(f"Not enough historical data for '{selected_category}' to create {MAX_PREDICTIVE_LAG} lags "
          f"and a {ROLLING_MEAN_WINDOW}-month rolling mean. Ensure you have sufficient historical data.")
    exit() # Exit if not enough data

print(f"Data shape after creating features and dropping NaNs: {monthly.shape}")

# === Step 5: Train the Forecasting Model ===
print("--- Step 5: Training the Forecasting Model ---")
# Define the features (X) and the target (y) for the model.
features = [
    'MONTH_SIN',
    'MONTH_COS'
] + [f'QUANTITY_LAG_{i}' for i in range(1, MAX_PREDICTIVE_LAG + 1)] \
  + [f'RETAIL_TRANSFERS_LAG_{i}' for i in range(1, MAX_PREDICTIVE_LAG + 1)] \
  + [f'WAREHOUSE_SALES_LAG_{i}' for i in range(1, MAX_PREDICTIVE_LAG + 1)] \
  + [f'QUANTITY_ROLLING_MEAN_{ROLLING_MEAN_WINDOW}M']

# Ensure all features exist in the monthly DataFrame before selecting them
missing_features = [f for f in features if f not in monthly.columns]
if missing_features:
    print(f"Error: Missing features in the dataset for model training: {missing_features}")
    print("This might happen if your category has too few data points or incorrect column names.")
    exit()

X = monthly[features]
y = monthly['QUANTITY']

# Initialize and train the RandomForestRegressor model.
# For better accuracy, consider hyperparameter tuning or more advanced models like LightGBM/XGBoost.
model = RandomForestRegressor(n_estimators=100, random_state=42, n_jobs=-1)
model.fit(X, y)
print("Model training complete.")

# === Step 8: Model Evaluation ===
print("--- Step 8: Model Evaluation ---")
# Make predictions on the training data
y_pred = model.predict(X)

# Calculate evaluation metrics
rmse = np.sqrt(mean_squared_error(y, y_pred))
mae = mean_absolute_error(y, y_pred)
r2 = r2_score(y, y_pred)

print(f"Model Evaluation (on training data for '{selected_category}' category):")
print(f"  Root Mean Squared Error (RMSE): {rmse:.2f}")
print(f"  Mean Absolute Error (MAE): {mae:.2f}")
print(f"  R-squared (R2): {r2:.2f}")

import joblib # Added at the top of the script
# ...
joblib.dump(model, MODEL_FILENAME)
print("Model saved successfully.")

loaded_model = joblib.load(MODEL_FILENAME)
print("Model loaded successfully.")

# === Step 6: Predicting Next 5 Months ===
print("--- Step 6: Predicting Next 5 Months ---")
forecast_results = []
# Get the last row of the monthly aggregated data to start the forecast from.
if monthly.empty:
    print("Cannot forecast: Monthly data is empty after processing. Exiting.")
    exit()
latest = monthly.iloc[-1].copy()

# Initialize last known values for rolling forecast
# For QUANTITY lags, we will update these with predictions.
last_quantities = [latest[f'QUANTITY_LAG_{i}'] for i in range(1, MAX_PREDICTIVE_LAG + 1)][::-1] # Reverse for easy append/pop
last_quantities.insert(0, latest['QUANTITY']) # Add current month's actual quantity

# For RETAIL_TRANSFERS_LAG and WAREHOUSE_SALES_LAG, we will use their last known actual values
# for all future forecasts, as we are not predicting these components individually.
last_retail_transfers_actual = [latest[f'RETAIL_TRANSFERS_LAG_{i}'] for i in range(1, MAX_PREDICTIVE_LAG + 1)][::-1]
last_retail_transfers_actual.insert(0, latest['RETAIL_TRANSFERS'])

last_warehouse_sales_actual = [latest[f'WAREHOUSE_SALES_LAG_{i}'] for i in range(1, MAX_PREDICTIVE_LAG + 1)][::-1]
last_warehouse_sales_actual.insert(0, latest['WAREHOUSE_SALES'])


initial_rolling_mean = latest[f'QUANTITY_ROLLING_MEAN_{ROLLING_MEAN_WINDOW}M']

for i in range(1, FORECAST_MONTHS + 1):
    # Determine the date for the forecasted month.
    next_date = latest['DATE'] + pd.DateOffset(months=i) # Use latest['DATE'] here to build from current last actual date
    next_month = next_date.month
    next_month_sin = np.sin(2 * np.pi * next_month / 12)
    next_month_cos = np.cos(2 * np.pi * next_month / 12)

    # Calculate future rolling mean based on current 'last_quantities'
    current_window_for_rolling_quantity = last_quantities[:ROLLING_MEAN_WINDOW]
    future_rolling_mean_quantity = np.mean(current_window_for_rolling_quantity) if len(current_window_for_rolling_quantity) == ROLLING_MEAN_WINDOW else initial_rolling_mean

    # Prepare the input for the next prediction.
    # For QUANTITY_LAG_j, use the values from 'last_quantities' (rolling predictions).
    # For RETAIL_TRANSFERS_LAG_j and WAREHOUSE_SALES_LAG_j, use their last known actuals.
    future_input_data = pd.DataFrame([{
        'MONTH_SIN': next_month_sin,
        'MONTH_COS': next_month_cos,
        **{f'QUANTITY_LAG_{j}': last_quantities[j-1] for j in range(1, MAX_PREDICTIVE_LAG + 1)},
        **{f'RETAIL_TRANSFERS_LAG_{j}': last_retail_transfers_actual[j-1] for j in range(1, MAX_PREDICTIVE_LAG + 1)},
        **{f'WAREHOUSE_SALES_LAG_{j}': last_warehouse_sales_actual[j-1] for j in range(1, MAX_PREDICTIVE_LAG + 1)},
        f'QUANTITY_ROLLING_MEAN_{ROLLING_MEAN_WINDOW}M': future_rolling_mean_quantity
    }])

    # Make the prediction.
    prediction = model.predict(future_input_data)[0]
    prediction = max(0, prediction) # Ensure quantity is not negative

    # Store the forecast result.
    forecast_results.append({'DATE': next_date, 'PREDICTED_QUANTITY': prediction})

    # Update lag quantities for the next iteration (rolling forecast)
    last_quantities.insert(0, prediction) # New prediction becomes QUANTITY_LAG_1
    last_quantities = last_quantities[:MAX_PREDICTIVE_LAG] # Keep only the required number of lags

    # For subsequent forecasts, the lagged RETAIL/WAREHOUSE values just repeat their last known actuals
    # as we don't have predictions for them specifically.
    last_retail_transfers_actual.insert(0, last_retail_transfers_actual[0])
    last_retail_transfers_actual = last_retail_transfers_actual[:MAX_PREDICTIVE_LAG]

    last_warehouse_sales_actual.insert(0, last_warehouse_sales_actual[0])
    last_warehouse_sales_actual = last_warehouse_sales_actual[:MAX_PREDICTIVE_LAG]

# Convert forecast results to a DataFrame.
forecast_df = pd.DataFrame(forecast_results)

print("Forecasting complete.")

# === Step 7: Plot Actual + Forecast ===
print("--- Step 7: Plotting Actual vs. Forecasted Sales ---")
plt.figure(figsize=(12, 6))

# Plot historical actual sales.
plt.plot(monthly['DATE'], monthly['QUANTITY'], label="Actual Sales", marker='o')

# Plot the forecasted sales.
plt.plot(forecast_df['DATE'], forecast_df['PREDICTED_QUANTITY'], label="Forecast (Next 5 Months)", linestyle='--', marker='x', color='orange')

plt.title(f"Quantity Forecast for '{selected_category.title()}' Category")
plt.xlabel("Date")
plt.ylabel("Quantity")
plt.grid(True)
plt.legend()
plt.tight_layout()
plt.show()
print("Forecast plot generated.")

# === Step 9: Print Forecasted Values ===
print(f"\n🔮 5-Month Forecast for '{selected_category.title()}':")
for row in forecast_results:
    print(f"{row['DATE'].strftime('%B %Y')}: {row['PREDICTED_QUANTITY']:.2f} units")

# Optionally save the forecasts
forecast_df.to_csv(FORECAST_CSV_5_MONTHS, index=False)
print(f"\nForecast for {FORECAST_MONTHS} months saved to '{FORECAST_CSV_5_MONTHS}'")

print("\n--- Script Finished ---")