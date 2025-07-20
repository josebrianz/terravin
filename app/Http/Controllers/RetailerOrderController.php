<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class RetailerOrderController extends Controller
{
    public function index()
    {
        $retailerId = Auth::id();
        // Orders received from customers (customer -> retailer)
        $ordersReceived = Order::where('vendor_id', $retailerId)->with('vendor')->latest()->get();
        // Orders placed by this retailer (retailer -> vendor/company)
        $ordersPlaced = Order::where('user_id', $retailerId)->with('vendor')->latest()->get();
        return view('retailer.orders', compact('ordersPlaced', 'ordersReceived'));
    }
} 