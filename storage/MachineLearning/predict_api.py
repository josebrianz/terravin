from flask import Flask, request, jsonify
import pandas as pd
import joblib
import os

app = Flask(__name__)

# --- Configuration ---
MODEL_FILENAME = os.path.join(os.path.dirname(__file__), "sales_forecast_model.joblib")
MAX_PREDICTIVE_LAG = 12
ROLLING_MEAN_WINDOW = 3
FEATURES = [
    'MONTH_SIN', 'MONTH_COS'
] + [f'QUANTITY_LAG_{i}' for i in range(1, MAX_PREDICTIVE_LAG + 1)] \
  + [f'RETAIL_TRANSFERS_LAG_{i}' for i in range(1, MAX_PREDICTIVE_LAG + 1)] \
  + [f'WAREHOUSE_SALES_LAG_{i}' for i in range(1, MAX_PREDICTIVE_LAG + 1)] \
  + [f'QUANTITY_ROLLING_MEAN_{ROLLING_MEAN_WINDOW}M']

# Load the model once at startup
loaded_model = joblib.load(MODEL_FILENAME)

@app.route('/predict', methods=['POST'])
def predict():
    try:
        input_data = request.get_json()
        prediction_df = pd.DataFrame([input_data])
        prediction_df = prediction_df[FEATURES]
        prediction = loaded_model.predict(prediction_df)[0]
        prediction = max(0, prediction)
        return jsonify({'predicted_quantity': float(prediction)})
    except Exception as e:
        return jsonify({'error': str(e)}), 400

if __name__ == '__main__':
    app.run(port=5001)