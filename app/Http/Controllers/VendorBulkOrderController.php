<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class VendorBulkOrderController extends Controller
{
    // Show the bulk order form
    public function showForm()
    {
        $products = Inventory::where('is_active', true)->orderBy('name')->get(['id', 'name', 'quantity as stock', 'unit_price']);
        return view('vendor.bulk-order', compact('products'));
    }

    // Handle the bulk order submission
    public function submit(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*' => 'exists:inventories,id',
            'quantities' => 'required|array',
        ]);
        $user = Auth::user();
        $items = [];
        $total = 0;
        foreach ($request->products as $productId) {
            $qty = (int)($request->quantities[$productId] ?? 0);
            if ($qty > 0) {
                $product = Inventory::find($productId);
                $items[] = [
                    'wine_id' => $product->id,
                    'wine_name' => $product->name,
                    'wine_category' => $product->category ?? '',
                    'quantity' => $qty,
                    'unit_price' => $product->unit_price,
                ];
                $total += $product->unit_price * $qty;
            }
        }
        if (empty($items)) {
            return back()->with('error', 'Please select at least one product and quantity.');
        }
        // Always set as Bulk Order for vendor-to-company orders
        $order = Order::create([
            'user_id' => $user->id,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => $user->phone ?? '',
            'items' => json_encode($items),
            'total_amount' => $total,
            'shipping_address' => $user->address ?? '',
            'notes' => 'Bulk order from vendor portal',
            'status' => 'pending',
            'payment_method' => 'Bulk Order', // Always set as Bulk Order
        ]);
        // Send email notifications
        try {
            \Mail::to($user->email)->send(new \App\Mail\VendorBulkOrderPlaced($order));
            \Mail::to(config('mail.admin_address', 'admin@example.com'))->send(new \App\Mail\AdminBulkOrderNotification($order));
        } catch (\Exception $e) {
            // Log or ignore email errors
        }
        return redirect()->route('vendor.bulk-order.confirmation', $order->id);
    }

    // Show confirmation page
    public function confirmation($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('vendor.bulk-order-confirmation', compact('order'));
    }

    // Show vendor's bulk order history
    public function history()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->paginate(15);
        return view('vendor.bulk-order-history', compact('orders'));
    }
} 