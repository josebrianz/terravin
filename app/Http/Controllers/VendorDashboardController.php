<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Inventory;
use App\Models\Shipment;
use App\Models\Procurement;
use App\Models\ComplianceDocument;
use App\Models\User;

class VendorDashboardController extends Controller
{
    public function index()
    {
        $vendorId = auth()->id();
        // Orders
        $orders = Order::where('vendor_id', $vendorId)->latest()->take(5)->get();
        // Inventory
        $inventory = Inventory::latest()->take(5)->get();
        // Shipments
        $shipments = Shipment::latest()->take(5)->get();
        // Product Specs & Compliance
        $complianceDocs = ComplianceDocument::where('type', 'spec')->orWhere('type', 'compliance')->latest()->take(5)->get();
        // Finance
        $invoices = Order::where('vendor_id', $vendorId)->where('status', '!=', 'paid')->latest()->take(5)->get();
        $payments = Order::where('vendor_id', $vendorId)->where('status', 'paid')->latest()->take(5)->get();
        // Reports
        $reports = Procurement::latest()->take(5)->get();
        // Communication (messages/notifications)
        $messages = []; // Placeholder, implement if you have a messages model
        $notifications = []; // Placeholder, implement if you have notifications
        // Contracts
        $contracts = []; // Placeholder, implement if you have a contracts model
        $vendor = $vendorId;
        return view('vendor.dashboard', compact('orders', 'inventory', 'shipments', 'complianceDocs', 'invoices', 'payments', 'reports', 'messages', 'notifications', 'contracts', 'vendor'));
    }
} 