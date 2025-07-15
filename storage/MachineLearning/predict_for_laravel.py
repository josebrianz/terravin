import sys
import json
import pandas as pd
import numpy as np
import joblib

# --- Configuration (Must match your training script) ---
MODEL_FILENAME = "sales_forecast_model.joblib"

# These values must match the ones used during model training
# from your comprehensive training script.
MAX_PREDICTIVE_LAG = 12
ROLLING_MEAN_WINDOW = 3

# Define the exact order of features used during model training.
# This list must be IDENTICAL to the 'features' list in your training script.
# It's constructed dynamically based on MAX_PREDICTIVE_LAG and ROLLING_MEAN_WINDOW
# to ensure consistency.
FEATURES = [
    'MONTH_SIN',
    'MONTH_COS'
] + [f'QUANTITY_LAG_{i}' for i in range(1, MAX_PREDICTIVE_LAG + 1)] \
  + [f'RETAIL_TRANSFERS_LAG_{i}' for i in range(1, MAX_PREDICTIVE_LAG + 1)] \
  + [f'WAREHOUSE_SALES_LAG_{i}' for i in range(1, MAX_PREDICTIVE_LAG + 1)] \
  + [f'QUANTITY_ROLLING_MEAN_{ROLLING_MEAN_WINDOW}M']

# --- Main Prediction Logic ---
def make_prediction(input_data_json):
    try:
        # Load the trained model
        loaded_model = joblib.load(MODEL_FILENAME)

        # Parse the input JSON string
        input_data = json.loads(input_data_json)

        # Convert input data to a Pandas DataFrame, ensuring correct column order.
        # It's crucial that the feature order matches the training data.
        prediction_df = pd.DataFrame([input_data])
        
        # Reorder columns to match FEATURES list. This is CRITICAL for correct predictions.
        # If any feature expected by the model is missing, this will raise a KeyError.
        prediction_df = prediction_df[FEATURES] 

        # Make the prediction
        prediction = loaded_model.predict(prediction_df)[0]
        prediction = max(0, prediction) # Ensure non-negative quantity

        # Return the prediction as a JSON string to standard output
        print(json.dumps({"predicted_quantity": float(prediction)}))

    except FileNotFoundError:
        # Error if the model file is not found
        print(json.dumps({"error": f"Model file '{MODEL_FILENAME}' not found. Ensure it's in the same directory as this script."}), file=sys.stderr)
        sys.exit(1)
    except json.JSONDecodeError:
        # Error if the input JSON is invalid
        print(json.dumps({"error": "Invalid JSON input. Please provide a valid JSON string."}), file=sys.stderr)
        sys.exit(1)
    except KeyError as e:
        # Error if a required feature is missing in the input JSON
        print(json.dumps({"error": f"Missing feature in input data: {e}. All {len(FEATURES)} features must be provided in the input JSON in the correct format."}), file=sys.stderr)
        sys.exit(1)
    except ValueError as e:
        # Handle cases where data types might be incorrect or other value errors during DataFrame creation/prediction
        print(json.dumps({"error": f"Data type or value error: {str(e)}. Check input data format."}), file=sys.stderr)
        sys.exit(1)
    except Exception as e:
        # Catch any other unexpected errors
        print(json.dumps({"error": f"An unexpected error occurred: {str(e)}", "type": str(type(e))}), file=sys.stderr)
        sys.exit(1)

if __name__ == "__main__":
    # Check if a command-line argument (the JSON string) is provided
    if len(sys.argv) > 1:
        # The first argument (sys.argv[1]) should be the JSON string of input features
        make_prediction(sys.argv[1])
    else:
        # Provide usage instructions if no argument is given
        print(json.dumps({"error": "No input data provided. Usage: python predict_for_laravel.py '{\"feature1\": value1, ...}'"}), file=sys.stderr)
        sys.exit(1)