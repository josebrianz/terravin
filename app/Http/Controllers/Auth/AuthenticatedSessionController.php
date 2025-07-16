<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Http\Response
    {
        $response = response()->view('auth.login');
        // Prevent browser from caching the login page
        $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->header('Pragma', 'no-cache');
        $response->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
        return $response;
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Custom redirect based on user role
        $user = Auth::user();

        // Log login event
        \App\Models\AuditLog::create([
            'user_id' => $user->id,
            'action' => 'login',
            'resource_type' => 'user',
            'resource_id' => $user->id,
            'old_values' => null,
            'new_values' => null,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'details' => null,
        ]);

        if ($user && $user->hasRole('Retailer')) {
            return redirect()->intended(route('retailer.dashboard', absolute: false));
        }
        if ($user && $user->hasRole('Wholesaler')) {
            return redirect()->intended(route('wholesaler.dashboard', absolute: false));
        }
        if ($user && $user->hasRole('Vendor')) {
            return redirect()->intended(route('vendor.dashboard', absolute: false));
        }
        if ($user && $user->hasRole('Customer')) {
            return redirect()->intended(route('customer.dashboard', absolute: false));
        }
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $response = redirect('/');
        // Prevent browser from caching after logout
        $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->header('Pragma', 'no-cache');
        $response->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
        return $response;
    }
}
