<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Inventory;
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
        $userId = auth()->id();
        $customerOrders = Order::with('user')
            ->where('user_id', '!=', $userId)
            ->latest()
            ->paginate(10, ['*'], 'customer_page');
        $myOrders = Order::with('user')
            ->where('user_id', $userId)
            ->latest()
            ->paginate(10, ['*'], 'my_page');
        return view('orders.index', compact('customerOrders', 'myOrders'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create(): View
    {
        if (auth()->user() && auth()->user()->isAdmin()) {
            abort(403, 'Admins are not allowed to place orders.');
        }
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

        // Merge 'Red Wine' and 'red wine' into a single category
        foreach ($wines as $wine) {
            if (strtolower($wine->category) === 'red wine') {
                $wine->category = 'Red Wine';
            }
        }
        $categories = $wines->groupBy('category');

        // Pass retailers to the checkout view if needed
        $retailers = \App\Models\User::where('role', 'Retailer')->get();

        return view('orders.catalog', compact('wines', 'categories', 'retailers'));
    }

    /**
     * Show the customer checkout page with retailer selection.
     */
    public function checkoutView()
    {
        $cartItems = \App\Models\CartItem::where('user_id', auth()->id())->with('inventory')->get();
        $retailers = \App\Models\User::where('role', 'Retailer')->get();
        return view('cart.checkout', compact('cartItems', 'retailers'));
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'notes' => 'nullable|string',
            'payment_method' => 'required|in:Cash on Delivery,Mobile Money,Card',
        ]);
        $user = auth()->user();
        if ($user->role === 'Retailer') {
            // Use session cart for retailers
            $cart = session()->get('retailer_cart', []);
            if (empty($cart)) {
                return redirect()->route('retailer.cart')->with('error', 'Your cart is empty.');
            }
            $items = [];
            $total = 0;
            foreach ($cart as $productId => $quantity) {
                $product = \App\Models\Inventory::find($productId);
                if (!$product) continue;
                $items[] = [
                    'inventory_id' => $product->id,
                    'wine_name' => $product->name,
                    'wine_category' => $product->category ?? '',
                    'quantity' => $quantity,
                    'unit_price' => $product->unit_price,
                ];
                $total += $product->unit_price * $quantity;
            }
            if (empty($items)) {
                return redirect()->route('retailer.cart')->with('error', 'Your cart is empty.');
            }
            $order = \App\Models\Order::create([
                'user_id' => $user->id,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $user->phone ?? '',
                'items' => json_encode($items),
                'total_amount' => $total,
                'shipping_address' => $request->shipping_address,
                'notes' => $request->notes,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'vendor_id' => 14, // Assign Owen as the vendor
            ]);
            // Optionally, create order_items records if needed
            foreach ($items as $item) {
                \App\Models\OrderItem::create([
                    'order_id'     => $order->id,
                    'inventory_id' => $item['inventory_id'],
                    'item_name'    => $item['wine_name'],
                    'unit_price'   => $item['unit_price'],
                    'quantity'     => $item['quantity'],
                    'subtotal'     => $item['unit_price'] * $item['quantity'],
                    'category'     => $item['wine_category'],
                ]);
            }
            // Clear session cart
            session()->forget('retailer_cart');
            return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
        }
        $user = auth()->user();
        // Customer must select a retailer
        $request->validate([
            'retailer_id' => 'required|exists:users,id',
        ]);
        $retailer = \App\Models\User::where('id', $request->retailer_id)->where('role', 'Retailer')->first();
        if (!$retailer) {
            return redirect()->back()->with('error', 'Selected retailer is invalid.');
        }
        $cartItems = \App\Models\CartItem::where('user_id', $user->id)->with('inventory')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $items = [];
        $total = 0;
        foreach ($cartItems as $item) {
            $items[] = [
                'inventory_id' => $item->inventory_id,
                'wine_name' => $item->inventory->name,
                'wine_category' => $item->inventory->category ?? '',
                'quantity' => $item->quantity,
                'unit_price' => $item->inventory->unit_price,
            ];
            $total += $item->inventory->unit_price * $item->quantity;
        }
        $order = \App\Models\Order::create([
            'user_id' => $user->id,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => $user->phone ?? '',
            'items' => json_encode($items),
            'total_amount' => $total,
            'shipping_address' => $request->shipping_address,
            'notes' => $request->notes,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'vendor_id' => $retailer->id,
        ]);
        // NEW: Create order_items records for each cart item
        foreach ($cartItems as $item) {
            if (!$item->inventory) continue; // skip if inventory record is missing
            \App\Models\OrderItem::create([
                'order_id'     => $order->id,
                'inventory_id' => $item->inventory_id,
                'item_name'    => $item->inventory->name,
                'unit_price'   => $item->inventory->unit_price,
                'quantity'     => $item->quantity,
                'subtotal'     => $item->inventory->unit_price * $item->quantity,
                'category'     => $item->inventory->category,
            ]);
        }
        // Clear cart
        \App\Models\CartItem::where('user_id', $user->id)->delete();
        if ($user->role === 'Retailer') {
            return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
        } else {
            return redirect()->route('orders.confirmation', $order->id)->with('success', 'Order placed successfully!');
        }
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order): View
    {
        if ($order->user_id === auth()->id()) {
            return view('orders.my-show', compact('order'));
        }
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit(Order $order): View
    {
        if ($order->user_id === auth()->id()) {
            return view('orders.my-edit', compact('order'));
        }
        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, Order $order): RedirectResponse
    {
        if ($order->user_id === auth()->id()) {
            // My Orders: allow editing shipping_address, notes, items, and status
            $request->validate([
                'items' => 'required|array',
                'items.*.wine_name' => 'required|string|max:255',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.unit_price' => 'required|numeric|min:0',
                'shipping_address' => 'required|string',
                'notes' => 'nullable|string',
                'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            ]);
            $total = 0;
            foreach ($request->items as $item) {
                $total += ($item['unit_price'] ?? 0) * ($item['quantity'] ?? 1);
            }
            $order->update([
                'items' => json_encode($request->items),
                'total_amount' => $total,
                'shipping_address' => $request->shipping_address,
                'notes' => $request->notes,
                'status' => $request->status,
            ]);
        } else {
            // Customer Orders: allow changing status and all customer fields
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
        }
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
        return view('orders.index', compact('orders'));
    }

    /**
     * Show only the logged-in customer's orders (order history).
     */
    public function customerOrders(): View
    {
        $orders = Order::where('customer_email', auth()->user()->email)
            ->latest()
            ->paginate(10);
        return view('orders.customer-index', compact('orders'));
    }

    public function confirmation($orderId)
    {
        $order = \App\Models\Order::with('orderItems.inventory')->where('id', $orderId)->where('user_id', auth()->id())->firstOrFail();
        return view('orders.confirmation', compact('order'));
    }

    public function history()
    {
        $orders = \App\Models\Order::with('orderItems.inventory')
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();
        return view('orders.history', compact('orders'));
    }

    public function retailerConfirmation($orderId)
    {
        $order = \App\Models\Order::where('id', $orderId)->where('user_id', auth()->id())->firstOrFail();
        return view('retailer.orders.confirmation', compact('order'));
    }
} 