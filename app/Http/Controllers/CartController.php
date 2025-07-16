<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // View cart contents
    public function index()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->with('wine')->get();
        return view('cart.index', compact('cartItems'));
    }

    // Add item to cart
    public function add(Request $request)
    {
        try {
            if (!auth()->check()) {
                return response()->json(['success' => false, 'message' => 'Not authenticated'], 401);
            }

            $validated = $request->validate([
                'wine_id' => 'required|exists:inventories,id',
                'quantity' => 'required|integer|min:1',
            ]);

            $cartItem = \App\Models\CartItem::firstOrNew([
                'user_id' => auth()->id(),
                'wine_id' => $validated['wine_id'],
            ]);
            $cartItem->quantity += $validated['quantity'];
            $cartItem->save();

            return response()->json(['success' => true, 'message' => 'Added to cart']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Update item quantity
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        $cartItem = CartItem::where('user_id', Auth::id())->findOrFail($id);
        $cartItem->quantity = $request->quantity;
        $cartItem->save();
        return response()->json(['success' => true, 'message' => 'Cart updated']);
    }

    // Remove item from cart
    public function remove($id)
    {
        $cartItem = CartItem::where('user_id', Auth::id())->findOrFail($id);
        $cartItem->delete();
        return response()->json(['success' => true, 'message' => 'Item removed']);
    }

    public function checkout()
    {
        $cartItems = \App\Models\CartItem::where('user_id', Auth::id())->with('wine')->get();
        return view('cart.checkout', compact('cartItems'));
    }
}
