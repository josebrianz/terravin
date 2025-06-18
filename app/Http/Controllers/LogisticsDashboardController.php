<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\Order;
use App\Models\Inventory;

class LogisticsDashboardController extends Controller
{
    public function index()
    {
        // Fetch key metrics
        $totalShipments = Shipment::count();
        $pendingShipments = Shipment::where('status', 'pending')->count();
        $inTransitShipments = Shipment::where('status', 'in_transit')->count();
        $deliveredShipments = Shipment::where('status', 'delivered')->count();

        // Fetch inventory levels (example: low stock items)
        $lowStockItems = Inventory::where('quantity', '<', 10)->get();

        // Fetch recent shipments
        $recentShipments = Shipment::latest()->take(5)->get();

        // Fetch recent orders
        $recentOrders = Order::latest()->take(5)->get();

        return view('logistics.dashboard', compact(
            'totalShipments',
            'pendingShipments',
            'inTransitShipments',
            'deliveredShipments',
            'lowStockItems',
            'recentShipments',
            'recentOrders'
        ));
    }
} 