<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class RetailerOrderController extends Controller
{
    public function index()
    {
        $orders = \App\Models\Order::where('user_id', auth()->id())
            ->with('vendor')
            ->latest()
            ->paginate(15);
        return view('retailer.orders', compact('orders'));
    }

    /**
     * Update the status of an order received by the retailer. If status is changed to 'shipped', reduce inventory.
     */
    public function updateStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);
        $retailerId = Auth::id();
        $order = Order::where('id', $orderId)->where('vendor_id', $retailerId)->firstOrFail();
        $oldStatus = $order->status;
        $order->status = $request->status;
        $order->save();

        // Reduce inventory only when status changes to 'shipped'
        if ($oldStatus !== 'shipped' && $request->status === 'shipped') {
            $items = is_array($order->items) ? $order->items : json_decode($order->items, true);
            foreach ($items as $item) {
                $wineId = $item['wine_id'] ?? $item['inventory_id'] ?? null;
                $qty = $item['quantity'] ?? 0;
                if (!$wineId || $qty <= 0) continue;
                // Decrease retailer's inventory
                $retailerInventory = \App\Models\Inventory::where('id', $wineId)
                    ->where('user_id', $retailerId)
                    ->first();
                if ($retailerInventory && $retailerInventory->quantity >= $qty) {
                    $retailerInventory->quantity -= $qty;
                    $retailerInventory->save();
                }
            }
        }
        return back()->with('success', 'Order status updated!');
    }
} 