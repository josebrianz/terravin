<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index(): View
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create(): View
    {
        $wines = \App\Models\Inventory::where('is_active', true)
            ->where('quantity', '>', 0)
            ->orderBy('category')
            ->orderBy('name')
            ->get();
        return view('orders.create', compact('wines'));
    }

    /**
     * Display wine catalog for customers.
     */
    public function catalog(): View
    {
        $wines = \App\Models\Inventory::where('is_active', true)
            ->where('quantity', '>', 0)
            ->orderBy('category')
            ->orderBy('name')
            ->get();
        
        $categories = $wines->groupBy('category');
        
        return view('orders.catalog', compact('wines', 'categories'));
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:20',
            'items' => 'required|array',
            'items.*.wine_id' => 'required|exists:inventories,id',
            'items.*.wine_name' => 'required|string|max:255',
            'items.*.wine_category' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'shipping_address' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        // Check inventory availability and update quantities
        foreach ($request->items as $item) {
            $inventory = \App\Models\Inventory::find($item['wine_id']);
            if (!$inventory) {
                return back()->withErrors(['items' => 'Selected wine not found in inventory.']);
            }
            
            if ($inventory->quantity < $item['quantity']) {
                return back()->withErrors(['items' => "Insufficient stock for {$inventory->name}. Available: {$inventory->quantity}"]);
            }
            
            // Update inventory quantity
            $inventory->decrement('quantity', $item['quantity']);
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'items' => json_encode($request->items),
            'total_amount' => $request->total_amount,
            'shipping_address' => $request->shipping_address,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order created successfully.');
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order): View
    {
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit(Order $order): View
    {
        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:20',
            'items' => 'required|array',
            'items.*.wine_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'shipping_address' => 'required|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'items' => json_encode($request->items),
            'total_amount' => $request->total_amount,
            'shipping_address' => $request->shipping_address,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();
        return redirect()->route('orders.index')
            ->with('success', 'Order deleted successfully.');
    }

    /**
     * Display pending orders.
     */
    public function pending(): View
    {
        $orders = Order::where('status', 'pending')
            ->with('user')
            ->latest()
            ->paginate(10);
        return view('orders.pending', compact('orders'));
    }
} 