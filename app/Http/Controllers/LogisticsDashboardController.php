<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\Order;
use App\Models\Inventory;
use Carbon\Carbon;

class LogisticsDashboardController extends Controller
{
    public function index()
    {
        // Fetch key metrics
        $totalShipments = Shipment::count();
        $pendingShipments = Shipment::where('status', 'pending')->count();
        $inTransitShipments = Shipment::where('status', 'in_transit')->count();
        $deliveredShipments = Shipment::where('status', 'delivered')->count();

        // Revenue calculations (sum related order's total_amount)
        $totalRevenue = Shipment::where('status', 'delivered')
            ->with('order')
            ->get()
            ->sum(function($shipment) {
                return $shipment->order->total_amount ?? 0;
            });

        $monthlyRevenue = Shipment::where('status', 'delivered')
            ->whereMonth('actual_delivery_date', now()->month)
            ->whereYear('actual_delivery_date', now()->year)
            ->with('order')
            ->get()
            ->sum(function($shipment) {
                return $shipment->order->total_amount ?? 0;
            });

        // Inventory
        $lowStockItems = Inventory::where('quantity', '<', 10)->get();
        $lowStockItemsList = $lowStockItems;

        // Overdue shipments
        $overdueShipments = Shipment::where('status', '!=', 'delivered')
            ->where('estimated_delivery_date', '<', now())
            ->get();
        $overdueShipmentsCount = $overdueShipments->count();

        // Recent shipments
        $recentShipments = Shipment::latest()->take(5)->get();

        // Chart data (last 6 months revenue)
        $revenueData = [];
        $months = collect(range(0, 5))->map(function ($i) {
            return now()->subMonths($i)->format('M Y');
        })->reverse();
        foreach ($months as $monthLabel) {
            $date = Carbon::createFromFormat('M Y', $monthLabel);
            $revenueData[$monthLabel] = Shipment::where('status', 'delivered')
                ->whereMonth('actual_delivery_date', $date->month)
                ->whereYear('actual_delivery_date', $date->year)
                ->with('order')
                ->get()
                ->sum(function($shipment) {
                    return $shipment->order->total_amount ?? 0;
                });
        }

        // Shipment status data for chart
        $shipmentStatusData = [
            'Pending' => $pendingShipments,
            'In Transit' => $inTransitShipments,
            'Delivered' => $deliveredShipments,
            'Overdue' => $overdueShipmentsCount,
        ];

        return view('logistics.dashboard', compact(
            'totalShipments',
            'pendingShipments',
            'inTransitShipments',
            'deliveredShipments',
            'totalRevenue',
            'monthlyRevenue',
            'lowStockItems',
            'lowStockItemsList',
            'overdueShipments',
            'overdueShipmentsCount',
            'recentShipments',
            'revenueData',
            'shipmentStatusData'
        ));
    }

    public function getShipmentDetails($id)
    {
        $shipment = \App\Models\Shipment::with(['order.user'])->findOrFail($id);
        return response()->json([
            'shipment' => $shipment
        ]);
    }
} 