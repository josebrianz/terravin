<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class VendorOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendorId = Auth::id();
        // Show all orders where the vendor is the current user
        $orders = Order::where('vendor_id', $vendorId)
            ->with(['user', 'orderItems'])
            ->latest()
            ->paginate(15);
        return view('vendor.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vendorId = Auth::id();
        $order = Order::where('id', $id)
            ->where('vendor_id', $vendorId)
            ->with(['user', 'orderItems'])
            ->firstOrFail();
        return view('vendor.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $vendorId = Auth::id();
        $order = Order::where('id', $id)
            ->where('vendor_id', $vendorId)
            ->with(['user', 'orderItems'])
            ->firstOrFail();
        return view('vendor.orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $vendorId = Auth::id();
        $order = Order::where('id', $id)
            ->where('vendor_id', $vendorId)
            ->firstOrFail();

        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'notes' => 'nullable|string',
        ]);

        $order->status = $validated['status'];
        $order->notes = $validated['notes'];
        $order->save();

        return redirect()->route('vendor.orders.show', $order->id)
            ->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
