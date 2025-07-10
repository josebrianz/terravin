<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Shipment;
use App\Models\Inventory;
use App\Models\Procurement;

class WholesalerDashboardController extends Controller
{
    public function index()
    {
        // Inventory & Catalog
        $stockLevel = Inventory::sum('quantity');
        $catalogCount = Inventory::count();
        $trackedBatches = \App\Models\Batch::count();

        // Orders
        $ordersToManufacturers = Order::latest()->take(5)->get();
        $ordersFromRetailers = Order::latest()->take(5)->get();

        // Pricing & Discounts (placeholders, implement logic as needed)
        $bulkDiscount = '10% for 100+ units';
        $promo = 'Summer Sale - 5% off';
        $customPricing = 'RetailerX: UGX 18,000/bottle';

        // Shipments & Logistics
        $shipments = Shipment::latest()->take(5)->get();
        $shipmentInTransit = $shipments->firstWhere('status', 'in_transit');
        $expectedDelivery = $shipmentInTransit ? $shipmentInTransit->estimated_delivery_date?->format('M d, Y') : null;
        $logisticsPartner = $shipmentInTransit ? $shipmentInTransit->carrier : null;

        // Financials
        $outstandingInvoices = Order::where('status', '!=', 'paid')->sum('total_amount');
        $creditTerms = 'Net 30'; // Placeholder, implement if you have a credit terms model/field
        $lastPayment = Order::where('status', 'paid')->latest('updated_at')->first()?->total_amount ?? 0;

        // Analytics
        $salesThisMonth = Order::where('status', 'delivered')
            ->whereMonth('created_at', now()->month)
            ->sum('total_amount');
        $inventoryTurnover = 2.1; // Placeholder, implement calculation if needed
        $forecast = 'Stable'; // Placeholder, implement logic if needed

        // Advanced Analytics
        // Inventory Turnover: COGS / avg inventory (simplified: delivered order total / avg inventory)
        $deliveredOrders = \App\Models\Order::where('status', 'delivered')->whereYear('created_at', now()->year)->get();
        $cogs = $deliveredOrders->sum('total_amount');
        $avgInventory = (Inventory::sum('quantity') + Inventory::sum('quantity')) / 2 ?: 1; // crude avg, adjust as needed
        $inventoryTurnover = $avgInventory ? round($cogs / $avgInventory, 2) : 0;

        // Sales Trends: sales per month for last 6 months
        $salesTrends = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $salesTrends[$month->format('M Y')] = \App\Models\Order::where('status', 'delivered')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_amount');
        }

        // Simple Forecast: average of last 3 months sales
        $recentSales = array_slice(array_values($salesTrends), -3);
        $forecast = count($recentSales) ? round(array_sum($recentSales) / count($recentSales)) : 0;

        // CRM
        $retailerProfiles = \App\Models\User::where('role', 'Retailer')->take(5)->get();

        // Compliance (placeholders)
        $importPermit = 'Valid';
        $safetySheet = 'Available';
        $traceability = 'Up to Date';

        return view('wholesaler.dashboard', compact(
            'stockLevel',
            'catalogCount',
            'trackedBatches',
            'ordersToManufacturers',
            'ordersFromRetailers',
            'bulkDiscount',
            'promo',
            'customPricing',
            'shipments',
            'shipmentInTransit',
            'expectedDelivery',
            'logisticsPartner',
            'outstandingInvoices',
            'creditTerms',
            'lastPayment',
            'salesThisMonth',
            'inventoryTurnover',
            'salesTrends',
            'forecast',
            'retailerProfiles',
            'importPermit',
            'safetySheet',
            'traceability'
        ));
    }
} 