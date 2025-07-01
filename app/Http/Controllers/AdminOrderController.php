<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    // List all orders
    public function index()
    {
        $orders = Order::with('items')->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    // Show order details
    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // Update order status
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);
        $order->status = $request->status;
        $order->save();
        return redirect()->back()->with('success', 'Order status updated.');
    }

    // Delete/cancel order
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted.');
    }
} 