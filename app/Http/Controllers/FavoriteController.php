<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Inventory;

class FavoriteController extends Controller
{
    // List all favorites for the logged-in customer
    public function index()
    {
        $favorites = Favorite::where('customer_id', auth()->id())
            ->with('inventory')
            ->get();
        return view('customer.favorites', compact('favorites'));
    }

    // Add a favorite (AJAX)
    public function store(Request $request)
    {
        $request->validate(['inventory_id' => 'required|exists:inventories,id']);
        $favorite = Favorite::firstOrCreate([
            'customer_id' => auth()->id(),
            'inventory_id' => $request->inventory_id,
        ]);
        return response()->json(['success' => true, 'favorite_id' => $favorite->id]);
    }

    // Remove a favorite (AJAX)
    public function destroy(Request $request)
    {
        $request->validate(['inventory_id' => 'required|exists:inventories,id']);
        Favorite::where('customer_id', auth()->id())
            ->where('inventory_id', $request->inventory_id)
            ->delete();
        return response()->json(['success' => true]);
    }
} 