<?php

namespace App\Http\Controllers;

use App\Services\SalesPredictor;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB; // Assuming you get historical data from database

class SalesController extends Controller
{
    protected $salesPredictor;

    public function __construct(SalesPredictor $salesPredictor)
    {
        $this->salesPredictor = $salesPredictor;
    }

    public function showForecast()
    {
        // 1. Fetch historical data for the last 12 months (or MAX_PREDICTIVE_LAG)
        $last12MonthsData = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('inventories', 'order_items.inventory_id', '=', 'inventories.id')
            ->select(
                DB::raw('YEAR(orders.created_at) as year'),
                DB::raw('MONTH(orders.created_at) as month'),
                DB::raw('SUM(order_items.quantity) as quantity'),
                DB::raw('SUM(order_items.quantity) as retail_transfers'), // Adjust if you have specific columns
                DB::raw('SUM(order_items.quantity) as warehouse_sales')   // Adjust if you have specific columns
            )
            ->where('inventories.category', 'WINE') // Or any category you want
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->latest('orders.created_at')
            ->limit(12)
            ->get()
            ->toArray();

        // Convert stdClass objects to associative arrays for easier processing in prepareInputFeatures
        $formattedHistoricalData = [];
        foreach ($last12MonthsData as $data) {
            $formattedHistoricalData[] = [
                'quantity' => $data->quantity,
                'retail_transfers' => $data->retail_transfers,
                'warehouse_sales' => $data->warehouse_sales,
                // Add any other base data needed for feature engineering
            ];
        }


        // 2. Define the month you want to predict
        $predictionDate = Carbon::now()->addMonth(); // Example: next month

        try {
            $predictedQuantity = $this->salesPredictor->predictSingleMonth($formattedHistoricalData, $predictionDate);

            if ($predictedQuantity !== null) {
                return view('forecast.forecast', [
                    'category' => 'WINE',
                    'prediction_date' => $predictionDate->format('F Y'),
                    'predicted_quantity' => number_format($predictedQuantity, 2)
                ]);
            } else {
                return view('forecast.forecast', ['error' => 'Could not get a prediction.']);
            }
        } catch (\Exception $e) {
            return view('forecast.forecast', ['error' => 'Prediction error: ' . $e->getMessage()]);
        }
    }

    public function dashboard()
    {
        // Get all unique categories from inventories
        $categories = DB::table('inventories')->distinct()->pluck('category')->filter()->values();
        return view('forecast.forecast', compact('categories'));
    }

    public function predictCategory(Request $request)
    {
        $request->validate(['category' => 'required|string']);
        $category = $request->input('category');
        $results = [];
        $currentDate = Carbon::now();
        $last12MonthsData = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('inventories', 'order_items.inventory_id', '=', 'inventories.id')
            ->select(
                DB::raw('YEAR(orders.created_at) as year'),
                DB::raw('MONTH(orders.created_at) as month'),
                DB::raw('SUM(order_items.quantity) as quantity'),
                DB::raw('SUM(order_items.quantity) as retail_transfers'),
                DB::raw('SUM(order_items.quantity) as warehouse_sales')
            )
            ->where('inventories.category', $category)
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->latest('orders.created_at')
            ->limit(12)
            ->get()
            ->toArray();
        $formattedHistoricalData = [];
        foreach ($last12MonthsData as $data) {
            $formattedHistoricalData[] = [
                'quantity' => $data->quantity,
                'retail_transfers' => $data->retail_transfers,
                'warehouse_sales' => $data->warehouse_sales,
            ];
        }
        $history = $formattedHistoricalData;
        for ($i = 1; $i <= 5; $i++) {
            $predictionDate = $currentDate->copy()->addMonths($i);
            try {
                $predictedQuantity = $this->salesPredictor->predictSingleMonth($history, $predictionDate);
                $results[] = [
                    'month' => $predictionDate->format('F Y'),
                    'quantity' => $predictedQuantity
                ];
                // For rolling forecast, add the prediction to history
                array_push($history, [
                    'quantity' => $predictedQuantity,
                    'retail_transfers' => $history[count($history)-1]['retail_transfers'] ?? 0,
                    'warehouse_sales' => $history[count($history)-1]['warehouse_sales'] ?? 0,
                ]);
                if (count($history) > 12) array_shift($history);
            } catch (\Exception $e) {
                $results[] = [
                    'month' => $predictionDate->format('F Y'),
                    'quantity' => null,
                    'error' => $e->getMessage()
                ];
            }
        }
        return response()->json($results);
    }
}