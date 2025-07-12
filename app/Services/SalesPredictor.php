<?php

namespace App\Services;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Carbon\Carbon; // For date calculations
use Illuminate\Support\Facades\Http;

class SalesPredictor
{
    protected $pythonPath;
    protected $pythonScriptPath;
    protected $maxPredictiveLag = 12; // Must match your Python script's MAX_PREDICTIVE_LAG
    protected $rollingMeanWindow = 3; // Must match your Python script's ROLLING_MEAN_WINDOW

    public function __construct()
    {
        // Path to your Python executable (now using the virtual environment)
        $this->pythonPath = env('PYTHON_PATH', base_path('storage/MachineLearning/env/Scripts/python.exe'));

        // Path to your Python prediction script
        // Assuming 'predict_for_laravel.py' is in the storage/MachineLearning directory
        $this->pythonScriptPath = base_path('storage/MachineLearning/predict_for_laravel.py');
    }

    /**
     * Makes a prediction for a single future month.
     *
     * @param array $last12MonthsData An array of the last 12 months (or MAX_PREDICTIVE_LAG) of historical sales data.
     * This should include 'quantity', 'retail_transfers', 'warehouse_sales' for each month.
     * Order should be from oldest to newest.
     * @param Carbon $predictionDate The date for which to make the prediction (e.g., Carbon::now()->addMonth())
     * @return float|null Predicted quantity or null if an error occurs.
     * @throws \Exception
     */
    public function predictSingleMonth(array $last12MonthsData, Carbon $predictionDate): ?float
    {
        // Ensure we have enough data for lags
        if (count($last12MonthsData) < $this->maxPredictiveLag) {
            throw new \Exception("Not enough historical data provided. Need at least {$this->maxPredictiveLag} months.");
        }

        // Prepare the input features as expected by the Python script
        $inputFeatures = $this->prepareInputFeatures($last12MonthsData, $predictionDate);

        // Call the Flask API
        $response = Http::post('http://127.0.0.1:5001/predict', $inputFeatures);

        if ($response->successful()) {
            $result = $response->json();
            if (isset($result['predicted_quantity'])) {
                return (float) $result['predicted_quantity'];
            } elseif (isset($result['error'])) {
                throw new \Exception("Prediction failed: " . $result['error']);
            } else {
                throw new \Exception("Unexpected response from prediction API: " . $response->body());
            }
        } else {
            throw new \Exception("Prediction API call failed: " . $response->body());
        }
    }

    /**
     * Prepares the input feature array for the Python script.
     * This function needs to replicate the feature engineering logic for a single prediction point.
     *
     * @param array $last12MonthsData Sorted from oldest to newest. Each element is an array like ['quantity' => Q, 'retail_transfers' => R, 'warehouse_sales' => W]
     * @param Carbon $predictionDate The date for which to predict
     * @return array
     */
    protected function prepareInputFeatures(array $last12MonthsData, Carbon $predictionDate): array
    {
        $features = [];

        // Month cyclical features
        $month = $predictionDate->month;
        $features['MONTH_SIN'] = sin(2 * M_PI * $month / 12);
        $features['MONTH_COS'] = cos(2 * M_PI * $month / 12);

        // Lags
        // The last historical month is index count-1.
        // QUANTITY_LAG_1 refers to the quantity from the *last* known month.
        // So, $last12MonthsData[count($last12MonthsData) - 1] is the data for LAG_1
        // $last12MonthsData[count($last12MonthsData) - 2] is for LAG_2, and so on.

        for ($i = 1; $i <= $this->maxPredictiveLag; $i++) {
            $lagIndex = count($last12MonthsData) - $i;
            if ($lagIndex >= 0) {
                $features["QUANTITY_LAG_{$i}"] = (float) $last12MonthsData[$lagIndex]['quantity'];
                $features["RETAIL_TRANSFERS_LAG_{$i}"] = (float) $last12MonthsData[$lagIndex]['retail_transfers'];
                $features["WAREHOUSE_SALES_LAG_{$i}"] = (float) $last12MonthsData[$lagIndex]['warehouse_sales'];
            } else {
                // Fill with 0 or a reasonable default if not enough historical data for all lags.
                // Your Python script will also use 0 as fallback if the DataFrame creation provides it.
                $features["QUANTITY_LAG_{$i}"] = 0.0;
                $features["RETAIL_TRANSFERS_LAG_{$i}"] = 0.0;
                $features["WAREHOUSE_SALES_LAG_{$i}"] = 0.0;
            }
        }

        // Rolling Mean
        // Take the last `ROLLING_MEAN_WINDOW` quantities from $last12MonthsData
        $rollingQuantities = array_slice($last12MonthsData, -$this->rollingMeanWindow);
        $sumQuantities = 0;
        foreach ($rollingQuantities as $data) {
            $sumQuantities += $data['quantity'];
        }
        $features["QUANTITY_ROLLING_MEAN_{$this->rollingMeanWindow}M"] = (float) ($sumQuantities / count($rollingQuantities));


        return $features;
    }
}