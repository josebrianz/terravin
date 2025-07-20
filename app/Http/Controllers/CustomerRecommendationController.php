<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\Inventory;

class CustomerRecommendationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;
        $month = Carbon::now()->month;
        $recommendations = [];
        $error = null;
        try {
            $response = Http::timeout(10)->get('http://127.0.0.1:5000/recommend', [
                'user_id' => $userId,
                'month' => $month,
                'min_recs' => 20
            ]);
            if ($response->successful()) {
                $recommendations = $response->json('recommendations') ?? [];
                // For each recommendation, get the correct image filename from the inventories table
                foreach ($recommendations as &$rec) {
                    $rec['WINE NAME'] = $rec['item_name'] ?? '';
                    $rec['CATEGORY'] = $rec['category'] ?? '';
                    $rec['PRICE PER UNIT'] = $rec['unit_price'] ?? '';
                    $rec['IMAGE'] = $rec['item_image'] ?? '';
                    // Fix: If IMAGE is a JSON array string, extract the first filename
                    if (is_string($rec['IMAGE']) && str_starts_with($rec['IMAGE'], '[')) {
                        $images = json_decode($rec['IMAGE'], true);
                        if (is_array($images) && count($images) > 0) {
                            $rec['IMAGE'] = $images[0];
                        } else {
                            $rec['IMAGE'] = 'default.jpg';
                        }
                    }
                    $rec['VINTAGE'] = $rec['vintage'] ?? '';
                    $rec['REGION'] = $rec['region'] ?? '';
                    $rec['VARIETAL'] = $rec['varietal'] ?? '';
                    $rec['QUANTITY'] = $rec['quantity'] ?? '';
                    $rec['ID'] = $rec['id'] ?? '';
                    $rec['LOW_STOCK'] = $rec['low_stock'] ?? false;
                    $rec['DESCRIPTION'] = $rec['description'] ?? '';
                    // Optionally, fetch image from Inventory as before
                    $inventory = Inventory::where('name', $rec['WINE NAME'])->first();
                    if ($inventory && $inventory->image) {
                        $rec['IMAGE'] = $inventory->image;
                    }
                    // Ensure ID is set for Add to Cart functionality
                    $rec['ID'] = $inventory ? $inventory->id : '';
                }
                unset($rec);
            } else {
                $error = $response->json('detail') ?? 'Could not fetch recommendations.';
            }
        } catch (\Exception $e) {
            $error = 'Recommendation service unavailable.';
        }
        return view('customer.recommendations', compact('recommendations', 'error'));
    }
} 