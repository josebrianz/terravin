<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Inventory;
use App\Models\Procurement;

class RetailerDashboardController extends Controller
{
    public function index()
    {
        $pendingOrders = Order::where('status', 'pending')->count();
        $lowInventory = Inventory::where('quantity', '<', 10)->count();
        $recentProcurements = Procurement::latest()->take(5)->get();
        $procurements = $recentProcurements;
        $notifications = Order::whereIn('status', ['pending', 'processing'])->count();
        $recentOrders = Order::latest()->take(5)->get();
        $topProducts = Inventory::orderBy('quantity', 'asc')->take(5)->get();
        return view('retailer.dashboard', compact('pendingOrders', 'lowInventory', 'recentProcurements', 'procurements', 'notifications', 'recentOrders', 'topProducts'));
    }
} 