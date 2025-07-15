<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }
    if (auth()->check()) {
        $sessionCart = Cart::where('session_id', session()->getId())->first();
        $userCart = Cart::where('user_id', auth()->id())->first();
    
        if ($sessionCart && $userCart) {
            // Merge guest cart into user cart
            foreach ($sessionCart->items as $item) {
                $existingItem = $userCart->items()->where('product_id', $item->product_id)->first();
                if ($existingItem) {
                    $existingItem->update(['quantity' => $existingItem->quantity + $item->quantity]);
                } else {
                    $userCart->items()->create($item->toArray());
                }
            }
            $sessionCart->delete();
        } elseif ($sessionCart) {
            $sessionCart->update(['user_id' => auth()->id(), 'session_id' => null]);
        }
    }
}
