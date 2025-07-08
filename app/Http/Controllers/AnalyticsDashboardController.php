<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AnalyticsDashboardController extends Controller
{
    public function index()
    {
        // For now, just return the analytics dashboard view
        return view('analytics.dashboard');
    }

     public function predictSales(Request $request)
    {
        // *** COPY THIS ENTIRE predictSales METHOD INTO YOUR CONTROLLER ***

        // 1. Validate incoming request data
        $validatedData = $request->validate([
            'year'              => 'required|integer',
            'month'             => 'required|integer|min:1|max:12',
            'supplier'          => 'required|string',
            'item_description'  => 'required|string',
            'item_type'         => 'required|string',
            'retail_transfers'  => 'required|numeric',
            'warehouse_sales'   => 'required|numeric',
        ]);

        try {
            // 2. Send the data to your Flask API
            // Ensure the URL matches where your Flask API is running
            $response = Http::post('http://127.0.0.1:5000/predict', [
                'year'              => $validatedData['year'],
                'month'             => $validatedData['month'],
                'supplier'          => $validatedData['supplier'],
                'item_description'  => $validatedData['item_description'],
                'item_type'         => $validatedData['item_type'],
                'retail_transfers'  => (float)$validatedData['retail_transfers'],
                'warehouse_sales'   => (float)$validatedData['warehouse_sales']
            ]);

            // 3. Check if the API request was successful
            if ($response->successful()) {
                $predictedSales = $response->json()['predicted_sales'] ?? null;

                if ($predictedSales !== null) {
                    // 4. Pass the prediction back to your analytics dashboard view
                    // This will refresh the page with the prediction displayed
                    return view('analytics.dashboard', ['predicted_sales' => $predictedSales]);
                } else {
                    return redirect()->back()->with('error', 'Prediction service returned an invalid response. (No predicted_sales key)');
                }
            } else {
                // Handle API errors (e.g., 400 Bad Request, 500 Internal Server Error from Flask)
                $errorMessage = $response->json()['error'] ?? 'Unknown error from prediction service.';
                return redirect()->back()->with('error', 'Prediction failed: ' . $errorMessage);
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            // Handle connection errors (e.g., Flask app not running or wrong IP)
            return redirect()->back()->with('error', 'Could not connect to the prediction service. Please ensure your Python Flask API is running at http://127.0.0.1:5000.');
        } catch (\Exception $e) {
            // Catch any other unexpected errors during the process
            return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }
} 