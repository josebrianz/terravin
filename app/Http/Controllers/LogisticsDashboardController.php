<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Procurement;
use App\Models\Inventory;
use App\Models\User;
use App\Models\Shipment;
use Illuminate\Support\Facades\DB;


class LogisticsDashboardController extends Controller
{
    public function index()
    {
    $totalShipments = Shipment::count();
    $pendingShipments = Shipment::where('status', 'pending')->count();
    $inTransitShipments = Shipment::where('status', 'in_transit')->count();
    $deliveredShipments = Shipment::where('status', 'delivered')->count();

    $totalRevenue = Shipment::sum('shipping_cost');
    $monthlyRevenue = Shipment::whereMonth('created_at', now()->month)->sum('shipping_cost');

    $lowStockItems = Inventory::where('quantity', '<', 10)->get();
    $lowStockItemsList = $lowStockItems;

    $overdueShipments = Shipment::where('status', '!=', 'delivered')
        ->where('estimated_delivery_date', '<', now())
        ->get();
    $overdueShipmentsCount = $overdueShipments->count();

    $recentShipments = Shipment::with('order.user')->latest()->take(5)->get();

    $upcomingDeliveries = Procurement::where('expected_delivery', '>=', now())->get();

    $topSuppliers = Procurement::selectRaw('supplier_name, COUNT(*) as order_count, SUM(total_amount) as total_value')
        ->groupBy('supplier_name')
        ->orderBy('order_count', 'desc')
        ->take(5)
        ->get();

    $revenueData = Shipment::selectRaw("DATE_FORMAT(created_at, '%b') as month, SUM(shipping_cost) as total")
        ->groupBy('month')
        ->pluck('total', 'month');

    $shipmentStatusData = Shipment::select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->pluck('count', 'status');

    $warehouseCoords = [121.4737, 31.2304]; // Example: Shanghai

    $shipmentRoutes = Shipment::whereIn('status', ['pending', 'in_transit'])
        ->get()
        ->map(function($shipment) use ($warehouseCoords) {
            $destinationCoords = [121.5, 31.25]; // Example only
            return [
                'from' => $warehouseCoords,
                'to' => $destinationCoords,
                'status' => $shipment->status
            ];
        })
        ->values()
        ->all();

    $deliveryZones = [
        [
            [121.45, 31.22],
            [121.47, 31.22],
            [121.47, 31.24],
            [121.45, 31.24]
        ]
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
        'upcomingDeliveries',
        'topSuppliers',
        'revenueData',
        'shipmentStatusData',
        'shipmentRoutes',
        'deliveryZones'
    ));
}

    public function getShipmentDetails($shipmentId)
    {
        $shipment = \App\Models\Shipment::with('order.user')->findOrFail($shipmentId);
        return response()->json(['shipment' => $shipment]);
    }

    public function updateShipmentStatus(Request $request, $shipmentId)
    {
        $request->validate([
            'status' => 'required|in:pending,in_transit,delivered,cancelled'
        ]);

        $shipment = \App\Models\Shipment::findOrFail($shipmentId);
        $shipment->status = $request->status;
        $shipment->save();

        return response()->json(['success' => true]);
    }
}

   /* {
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
} */