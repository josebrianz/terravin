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

    // Retailer Cart: View Cart
    public function cart()
    {
        $cart = session('cart', []);
        $products = [];
        $total = 0;
        foreach ($cart as $id => $item) {
            $product = \App\Models\Inventory::find($id);
            if ($product) {
                $product->cart_quantity = $item['quantity'];
                $product->cart_subtotal = $product->price * $item['quantity'];
                $products[] = $product;
                $total += $product->cart_subtotal;
            }
        }
        return view('orders.cart', compact('products', 'total'));
    }

    // Retailer Cart: Add to Cart
    public function addToCart(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $cart = session('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $request->quantity;
        } else {
            $cart[$id] = ['quantity' => $request->quantity];
        }
        session(['cart' => $cart]);
        return back()->with('success', 'Product added to cart!');
    }

    // Retailer Cart: Remove from Cart
    public function removeFromCart($id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);
        return back()->with('success', 'Product removed from cart.');
    }

    // Retailer Cart: Checkout Page
    public function checkout()
    {
        $cart = session('cart', []);
        $products = [];
        $total = 0;
        foreach ($cart as $id => $item) {
            $product = \App\Models\Inventory::find($id);
            if ($product) {
                $product->cart_quantity = $item['quantity'];
                $product->cart_subtotal = $product->price * $item['quantity'];
                $products[] = $product;
                $total += $product->cart_subtotal;
            }
        }
        return view('orders.checkout', compact('products', 'total'));
    }

    // Retailer Cart: Process Checkout
    public function processCheckout(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty.');
        }
        $user = auth()->user();
        $items = [];
        $total = 0;
        foreach ($cart as $id => $item) {
            $product = \App\Models\Inventory::find($id);
            if ($product && $product->quantity >= $item['quantity']) {
                $items[] = [
                    'wine_id' => $product->id,
                    'wine_name' => $product->name,
                    'wine_category' => $product->category,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                ];
                $total += $product->price * $item['quantity'];
                $product->decrement('quantity', $item['quantity']);
            } else {
                return redirect()->route('cart.view')->with('error', 'Insufficient stock for ' . ($product->name ?? 'product') . '.');
            }
        }
        $order = \App\Models\Order::create([
            'user_id' => $user->id,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => '',
            'items' => $items,
            'total_amount' => $total,
            'shipping_address' => '',
            'notes' => '',
            'status' => 'pending',
        ]);
        session()->forget('cart');
        return redirect()->route('retailer.orders.show', $order->id)->with('success', 'Order placed successfully!');
    }

    // Increase cart item quantity
    public function increaseCartItem($id)
    {
        $cart = session('cart', []);
        if (isset($cart[$id])) {
            $product = \App\Models\Inventory::find($id);
            if ($product && $cart[$id]['quantity'] < $product->quantity) {
                $cart[$id]['quantity'] += 1;
                session(['cart' => $cart]);
                return back()->with('success', 'Quantity increased.');
            } else {
                return back()->with('error', 'Cannot add more than available stock.');
            }
        }
        return back()->with('error', 'Product not found in cart.');
    }

    // Decrease cart item quantity
    public function decreaseCartItem($id)
    {
        $cart = session('cart', []);
        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity'] -= 1;
                session(['cart' => $cart]);
                return back()->with('success', 'Quantity decreased.');
            } else {
                return back()->with('error', 'Quantity cannot be less than 1.');
            }
        }
        return back()->with('error', 'Product not found in cart.');
    }

    // Clear the entire cart
    public function clearCart()
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared.');
    }
} 