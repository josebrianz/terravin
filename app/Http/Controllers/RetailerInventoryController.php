<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class RetailerInventoryController extends Controller
{
    public function index()
    {
        // Fetch all wine items
        $allWines = \App\Models\Inventory::all();
        // Assign retailer-appropriate quantities (e.g., 3-20) to each item
        foreach ($allWines as $wine) {
            $wine->quantity = rand(3, 20);
        }
        // Paginate manually for demo (since it's a small set)
        $items = new \Illuminate\Pagination\LengthAwarePaginator(
            $allWines,
            $allWines->count(),
            15,
            1,
            ['path' => url()->current()]
        );
        return view('retailer.inventory', compact('items'));
    }
} 