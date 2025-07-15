<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogisticsDashboardController extends Controller
{
    // Dashboard overview
    public function index()
    {
        $total = Shipment::count();
        $pending = Shipment::pending()->count();
        $inTransit = Shipment::inTransit()->count();
        $delivered = Shipment::delivered()->count();
        $recent = Shipment::latest()->take(5)->get();
        return view('logistics.dashboard', compact('total', 'pending', 'inTransit', 'delivered', 'recent'));
    }

    // List all shipments
    public function shipments()
    {
        $shipments = Shipment::latest()->paginate(20);
        return view('logistics.shipments.index', compact('shipments'));
    }

    // List all shipments (for shipments.index route)
    public function shipmentsIndex()
    {
        $shipments = Shipment::latest()->paginate(20);
        return view('logistics.shipments.index', compact('shipments'));
    }

    // Show create shipment form
    public function create()
    {
        $orders = Order::all();
        return view('logistics.shipments.create', compact('orders'));
    }

    // Store new shipment
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'tracking_number' => 'nullable|string|unique:shipments',
            'status' => 'required|string',
            'carrier' => 'nullable|string',
            'shipping_cost' => 'nullable|numeric',
            'estimated_delivery_date' => 'nullable|date',
            'shipping_address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        $data['created_by'] = Auth::id();
        $shipment = Shipment::create($data);
        return redirect()->route('shipments.show', $shipment)->with('success', 'Shipment created successfully.');
    }

    // Show shipment details
    public function show(Shipment $shipment)
    {
        return view('logistics.shipments.show', compact('shipment'));
    }

    // Show edit shipment form
    public function edit(Shipment $shipment)
    {
        $orders = Order::all();
        return view('logistics.shipments.edit', compact('shipment', 'orders'));
    }

    // Update shipment
    public function update(Request $request, Shipment $shipment)
    {
        $data = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'tracking_number' => 'nullable|string|unique:shipments,tracking_number,' . $shipment->id,
            'status' => 'required|string',
            'carrier' => 'nullable|string',
            'shipping_cost' => 'nullable|numeric',
            'estimated_delivery_date' => 'nullable|date',
            'actual_delivery_date' => 'nullable|date',
            'shipping_address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        $data['updated_by'] = Auth::id();
        $shipment->update($data);
        return redirect()->route('shipments.show', $shipment)->with('success', 'Shipment updated successfully.');
    }

    // Delete shipment
    public function destroy(Shipment $shipment)
    {
        $shipment->delete();
        return redirect()->route('logistics.dashboard')->with('success', 'Shipment deleted successfully.');
    }
} 