<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Procurement;
use App\Models\Inventory;
use App\Models\User;

class LogisticsDashboardController extends Controller
{
    public function index()
    {
        // Fetch procurement-based logistics metrics
        $totalProcurements = Procurement::count();
        $orderedProcurements = Procurement::where('status', 'ordered')->count();
        $receivedProcurements = Procurement::where('status', 'received')->count();
        $overdueProcurements = Procurement::where('expected_delivery', '<', now())
            ->whereNotIn('status', ['received', 'cancelled'])
            ->count();

        // Fetch inventory levels for logistics planning
        $lowStockItems = Inventory::where('quantity', '<', 10)->get();
        $totalInventoryItems = Inventory::count();
        $totalInventoryValue = Inventory::sum('quantity');

        // Fetch recent procurements for logistics tracking
        $recentProcurements = Procurement::with(['requester', 'approver'])
            ->whereIn('status', ['ordered', 'received'])
            ->latest()
            ->take(10)
            ->get();

        // Fetch upcoming deliveries
        $upcomingDeliveries = Procurement::where('expected_delivery', '>=', now())
            ->whereNotIn('status', ['received', 'cancelled'])
            ->with('requester')
            ->orderBy('expected_delivery')
            ->take(10)
            ->get();

        // Fetch supplier performance for logistics
        $topSuppliers = Procurement::selectRaw('supplier_name, COUNT(*) as order_count, SUM(total_amount) as total_value')
            ->groupBy('supplier_name')
            ->orderBy('order_count', 'desc')
            ->take(5)
            ->get();

        // Calculate delivery performance
        $onTimeDeliveries = Procurement::where('status', 'received')
            ->where('actual_delivery', '<=', 'expected_delivery')
            ->count();
        $totalDeliveries = Procurement::where('status', 'received')->count();
        $onTimePercentage = $totalDeliveries > 0 ? round(($onTimeDeliveries / $totalDeliveries) * 100, 1) : 0;

        return view('logistics.dashboard', compact(
            'totalProcurements',
            'orderedProcurements',
            'receivedProcurements',
            'overdueProcurements',
            'lowStockItems',
            'totalInventoryItems',
            'totalInventoryValue',
            'recentProcurements',
            'upcomingDeliveries',
            'topSuppliers',
            'onTimePercentage',
            'onTimeDeliveries',
            'totalDeliveries'
        ));
    }
} 