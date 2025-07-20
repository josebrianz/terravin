<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RetailerCatalogController extends Controller
{
    public function index()
    {
        // Show all active inventory items
        $wines = \App\Models\Inventory::where('is_active', true)->get();
        return view('retailer.catalog', compact('wines'));
    }
}