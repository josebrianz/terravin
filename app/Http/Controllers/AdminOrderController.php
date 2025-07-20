<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    /**
     * Display admin orders dashboard with comprehensive order management.
     */
    public function index(Request $request): View
    {
        $query = Order::with(['user'])
            ->whereHas('user', function ($q) {
                $q->where('role', 'Vendor');
            });

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by customer name
        if ($request->filled('customer_name')) {
            $query->where('customer_name', 'like', '%' . $request->customer_name . '%');
        }

        // Filter by customer email
        if ($request->filled('customer_email')) {
            $query->where('customer_email', 'like', '%' . $request->customer_email . '%');
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $orders = $query->latest()->paginate(15);

        // Get order statistics
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'shipped_orders' => Order::where('status', 'shipped')->count(),
            'delivered_orders' => Order::where('status', 'delivered')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),
            'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total_amount'),
            'pending_revenue' => Order::where('status', 'pending')->sum('total_amount'),
        ];

        // Get recent orders for quick overview
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Get top customers
        $topCustomers = Order::select('customer_name', 'customer_email', DB::raw('COUNT(*) as order_count'), DB::raw('SUM(total_amount) as total_spent'))
            ->groupBy('customer_name', 'customer_email')
            ->orderBy('total_spent', 'desc')
            ->take(5)
            ->get();

        return view('admin.orders.index', compact('orders', 'stats', 'recentOrders', 'topCustomers'));
    }

    /**
     * Display the specified order with admin details.
     */
    public function show(Order $order): View
    {
        $order->load('user');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit(Order $order): View
    {
        $order->load('user');
        $wines = \App\Models\Inventory::where('is_active', true)->get();
        return view('admin.orders.edit', compact('order', 'wines'));
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'nullable|string|max:20',
            'shipping_address' => 'required|string',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_method' => 'required|in:Cash on Delivery,Mobile Money,Card',
            'notes' => 'nullable|string',
            'admin_notes' => 'nullable|string',
        ]);

        $order->update([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'shipping_address' => $request->shipping_address,
            'status' => $request->status,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order updated successfully.');
    }

    /**
     * Update only the status of the specified order.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);
        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        // Inventory transfer logic: only when status changes to delivered
        if ($oldStatus !== 'delivered' && $request->status === 'delivered') {
            $items = is_array($order->items) ? $order->items : json_decode($order->items, true);
            // Determine seller and buyer
            $buyerId = $order->user_id;
            $sellerId = $order->vendor_id ?? null; // null means company
            foreach ($items as $item) {
                $wineId = $item['wine_id'] ?? $item['inventory_id'] ?? null;
                $qty = $item['quantity'] ?? 0;
                if (!$wineId || $qty <= 0) continue;
                // Decrease seller's inventory
                $sellerInventory = \App\Models\Inventory::where('id', $wineId)
                    ->where('user_id', $sellerId)
                    ->first();
                if ($sellerInventory && $sellerInventory->quantity >= $qty) {
                    $sellerInventory->quantity -= $qty;
                    $sellerInventory->save();
                }
                // Increase buyer's inventory (create if not exists)
                $buyerInventory = \App\Models\Inventory::where('name', $sellerInventory ? $sellerInventory->name : $item['wine_name'])
                    ->where('user_id', $buyerId)
                    ->first();
                if ($buyerInventory) {
                    $buyerInventory->quantity += $qty;
                    $buyerInventory->save();
                } else if ($sellerInventory) {
                    $newInv = $sellerInventory->replicate();
                    $newInv->user_id = $buyerId;
                    $newInv->quantity = $qty;
                    $newInv->save();
                }
            }
        }
        return back()->with('success', 'Order status updated!');
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();
        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully.');
    }

    /**
     * Bulk update order statuses.
     */
    public function bulkUpdate(Request $request): RedirectResponse
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        Order::whereIn('id', $request->order_ids)->update([
            'status' => $request->status
        ]);

        return redirect()->route('admin.orders.index')
            ->with('success', count($request->order_ids) . ' orders updated successfully.');
    }

    /**
     * Export orders to CSV.
     */
    public function export(Request $request)
    {
        $query = Order::with('user');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->get();

        $filename = 'orders_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Order ID', 'Customer Name', 'Customer Email', 'Customer Phone',
                'Items', 'Total Amount', 'Status', 'Payment Method',
                'Shipping Address', 'Notes', 'Created At'
            ]);

                foreach ($orders as $order) {
                $items = $order->items;
                $itemsText = '';
                if (is_array($items) && count($items) > 0) {
                    foreach ($items as $item) {
                        $itemName = $item['wine_name'] ?? $item['item_name'] ?? 'Unknown Item';
                        $itemsText .= $itemName . ' (x' . $item['quantity'] . '), ';
                    }
                    $itemsText = rtrim($itemsText, ', ');
                }

                fputcsv($file, [
                        $order->id,
                        $order->customer_name,
                        $order->customer_email,
                    $order->customer_phone,
                    $itemsText,
                    $order->total_amount,
                        $order->status,
                    $order->payment_method,
                    $order->shipping_address,
                    $order->notes,
                    $order->created_at
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
            }

    /**
     * Generate invoice for an order.
     */
    public function invoice(Order $order): View
    {
        $order->load('user');
        return view('admin.orders.invoice', compact('order'));
    }

    /**
     * Get order statistics for dashboard.
     */
    public function getStats()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'shipped_orders' => Order::where('status', 'shipped')->count(),
            'delivered_orders' => Order::where('status', 'delivered')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),
            'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total_amount'),
            'pending_revenue' => Order::where('status', 'pending')->sum('total_amount'),
        ];

        return response()->json($stats);
    }
} 