<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierReportController extends Controller
{
    public function index()
    {
        // Example live data (replace with real queries in production)
        $rawMaterials = [
            ['name' => 'Grapes', 'stock' => 5000, 'unit' => 'kg'],
            ['name' => 'Yeast', 'stock' => 50, 'unit' => 'kg'],
            ['name' => 'Oak Barrels', 'stock' => 120, 'unit' => 'units'],
            ['name' => 'Bottles', 'stock' => 10000, 'unit' => 'units'],
        ];
        $recentOrders = [
            ['id' => 1001, 'items' => 'Grapes, Yeast', 'date' => '2025-07-15', 'status' => 'Pending'],
            ['id' => 1002, 'items' => 'Bottles, Corks', 'date' => '2025-07-16', 'status' => 'Approved'],
        ];
        $supplyStats = [
            'totalOrders' => 24,
            'pendingOrders' => 3,
            'deliveredOrders' => 18,
            'outOfStock' => 1,
        ];
        return view('supplier.reports', compact('rawMaterials', 'recentOrders', 'supplyStats'));
    }

    public function apiIndex()
    {
        $user = Auth::user();
        // Live data for this supplier
        $rawMaterials = \App\Models\Inventory::where('user_id', $user->id)
            ->select('name', 'quantity as stock', 'category as unit')
            ->get();
        $orders = \App\Models\Order::where('user_id', $user->id)->latest()->take(10)->get();
        $recentOrders = $orders->map(function($order) {
            return [
                'id' => $order->id,
                'items' => collect($order->orderItems)->pluck('item_name')->implode(', '),
                'date' => $order->created_at->toDateString(),
                'status' => ucfirst($order->status),
            ];
        });
        $supplyStats = [
            'totalOrders' => $orders->count(),
            'pendingOrders' => $orders->where('status', 'pending')->count(),
            'deliveredOrders' => $orders->where('status', 'delivered')->count(),
            'outOfStock' => \App\Models\Inventory::where('user_id', $user->id)->where('quantity', '<=', 0)->count(),
        ];
        return response()->json([
            'rawMaterials' => $rawMaterials,
            'recentOrders' => $recentOrders,
            'supplyStats' => $supplyStats,
        ]);
    }
} 