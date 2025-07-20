<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Inventory;
use App\Models\Procurement;
use App\Models\User;
use App\Models\OrderItem;

class ReportController extends Controller
{
    public function index()
    {
        // Top Retailers (users with most orders)
        $topRetailers = User::where('role', 'Retailer')
            ->withCount(['orders as orders_count' => function($q) {
                $q->whereNotNull('id');
            }])
            ->orderByDesc('orders_count')
            ->take(5)
            ->get();

        // Sales Summary
        $totalSales = Order::count();
        $totalRevenue = Order::sum('total_amount');

        // Inventory Stats
        $totalInventory = Inventory::count();
        $lowStockCount = Inventory::where('quantity', '<', 10)->count();

        // Best-selling Products
        $bestSellingProducts = OrderItem::select('item_name')
            ->selectRaw('SUM(quantity) as total_sold')
            ->groupBy('item_name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        return view('reports.index', [
            'topRetailers' => $topRetailers,
            'totalSales' => $totalSales,
            'totalRevenue' => $totalRevenue,
            'totalInventory' => $totalInventory,
            'lowStockCount' => $lowStockCount,
            'bestSellingProducts' => $bestSellingProducts,
        ]);
    }
}

