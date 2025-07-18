<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class VendorInventoryController extends Controller
{
    // List all inventory items (same as /inventory for now)
    public function index()
    {
        $items = Inventory::paginate(15);
        return view('vendor.inventory.index', compact('items'));
    }
} 