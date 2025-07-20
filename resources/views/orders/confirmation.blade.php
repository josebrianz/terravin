
@extends('layouts.minimal')

@section('title', 'Order Confirmation')

@push('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #5e0f0f;
            --primary-light: #8b1a1a;
            --secondary: #c8a97e;
            --cream: #f5f0e6;
            --light-bg: #f9f5ed;
            --text-dark: #2a2a2a;
            --border-radius: 18px;
            --shadow-md: 0 4px 24px rgba(94, 15, 15, 0.13);
        }
        body {
            font-family: 'Montserrat', sans-serif;
            color: var(--text-dark);
            background-color: var(--cream);
            line-height: 1.6;
        }
        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: var(--primary);
        }
        .wine-top-bar {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);

            color: white;
            padding: 0.75rem 0;
            box-shadow: 0 2px 10px rgba(94, 15, 15, 0.2);
            position: fixed;
            width: 100%;
            left: 0;
            top: 0;
            z-index: 1000;
        }
        .wine-brand {

            color: var(--secondary);
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: 600;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;

        }
        .wine-brand:hover {
            color: white;
            text-decoration: none;
        }

        .nav-links {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }
        .nav-link {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            font-size: 0.95rem;

            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            
            position: relative;
        }
        .nav-link:hover {
            color: var(--secondary);
            background-color: rgba(200, 169, 126, 0.1);
            text-decoration: none;
        }
        .nav-link.active {
            color: var(--secondary);
        }
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 5px;
            height: 5px;
            background-color: var(--secondary);
            border-radius: 50%;
        }
        .cart-link {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.2rem 0.7rem;
            border-radius: 50px;
            background: rgba(200, 169, 126, 0.08);
            transition: background 0.2s;
            position: relative;
        }
        .cart-link:hover {
            background: rgba(200, 169, 126, 0.18);
        }
        .cart-icon-container {
            position: relative;
            display: inline-block;
        }
        .cart-count-badge {
            position: absolute;
            top: -8px;
            right: -12px;
            background: var(--primary);
            color: #fff;
            border-radius: 50%;
            padding: 0.25em 0.6em;
            font-size: 1rem;
            font-weight: bold;
            border: 2px solid #fff;
            box-shadow: 0 2px 8px rgba(94,15,15,0.15);
            z-index: 2;
            transition: background 0.2s;
        }
        .cart-icon-container:hover .cart-count-badge {
            background: #7b2230;
        }
        .profile-photo-large {
            width: 72px !important;
            height: 72px !important;
            border-width: 6px !important;
            border-color: var(--secondary) !important;
            object-fit: cover;
        }
        .profile-photo-placeholder-large {
            width: 72px !important;
            height: 72px !important;
            border-width: 6px !important;
            border-color: var(--secondary) !important;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: #fff;
            font-size: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .user-name {
            color: var(--secondary) !important;
            font-weight: 600;
            font-size: 1.1rem;
        }
    </styl>
@endpush

@section('content')
<div class="wine-top-bar">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between" style="min-height: 80px;">
            <div class="d-flex align-items-center gap-3">
                <a class="wine-brand" href="{{ route('customer.dashboard') }}">
                    <i class="fas fa-wine-bottle"></i>
                </a>
                <nav class="wine-nav">
                    <ul class="nav-links d-flex align-items-center gap-3 mb-0" style="list-style:none;">
                        <li><a href="{{ route('customer.dashboard') }}" class="nav-link"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                        <li><a href="{{ route('customer.products') }}" class="nav-link"><i class="fas fa-shopping-bag"></i> Wine Shop</a></li>
                        <li><a href="{{ route('customer.favorites') }}" class="nav-link"><i class="fas fa-heart"></i> Favorites</a></li>
                        <li><a href="{{ route('customer.orders') }}" class="nav-link"><i class="fas fa-history"></i> Orders</a></li>
                        <li><a href="{{ route('help.index') }}" class="nav-link"><i class="fas fa-question-circle"></i> Help</a></li>
                    </ul>
                </nav>
            </div>
            <div class="d-flex align-items-center gap-4">
                @php
                    $cartCount = \App\Models\CartItem::where('user_id', Auth::id())->sum('quantity');
                @endphp
                <a href="{{ route('cart.index') }}" class="cart-link" style="display:inline-block;">
                    <span class="cart-icon-container">
                        <i class="fas fa-shopping-cart" style="font-size:2.2rem;color:var(--secondary);"></i>
                        <span class="cart-count-badge">{{ $cartCount }}</span>
                    </span>
                </a>
                @auth
                <div class="dropdown">
                    <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#" role="button" data-bs-toggle="dropdown">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}?v={{ time() }}" alt="{{ Auth::user()->name }}" class="profile-photo-large rounded-circle me-2" style="border: 6px solid var(--secondary);">
                        @else
                            <div class="profile-photo-placeholder-large rounded-circle d-flex align-items-center justify-content-center me-2" style="border: 6px solid var(--secondary); background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); width: 72px; height: 72px; color: #fff; font-size: 2rem;">
                                <span class="fw-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                        @endif
                        <span class="user-name">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user-edit me-2"></i> Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                    </ul>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                @endauth
            </div>
        </div>
    </div>
</div>
<div class="container py-5 text-center">
    <h2 class="mb-4 text-burgundy fw-bold">Thank You for Your Order!</h2>
    <div class="alert alert-success mb-4">Your order has been placed successfully. Below is your order summary.</div>
    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <h4 class="mb-3">Order #{{ $order->id }}</h4>
            @php
                $items = is_string($order->items) ? json_decode($order->items, true) : $order->items;
            @endphp
            <ul class="list-group mb-3 text-start">
                @foreach($items as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $item['wine_name'] }}</strong>
                            <span class="text-muted">x{{ $item['quantity'] }}</span>
                        </div>
                        <span>{{ format_usd($item['unit_price'] * $item['quantity']) }}</span>
                    </li>
                @endforeach
            </ul>
            <h5 class="fw-bold text-burgundy">Total: {{ format_usd($order->total_amount) }}</h5>

        </div>
    </div>
    <div class="main-content">
        <div class="container">
            <div class="confirmation-box">
                <h2 class="mb-3">Thank You for Your Order!</h2>
                <div class="alert alert-success">Your order has been placed successfully. Below is your order summary.</div>
                <table class="order-summary-table table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $items = is_array($order->items) ? $order->items : (json_decode($order->items, true) ?: []);
                            $total = 0;
                        @endphp
                        @foreach($items as $item)
                            <tr>
                                <td>{{ $item['wine_name'] ?? 'Wine' }} <span class="text-muted">x{{ $item['quantity'] ?? 1 }}</span></td>
                                <td class="text-end">${{ number_format(($item['unit_price'] ?? 0) * ($item['quantity'] ?? 1), 2) }}</td>
                            </tr>
                            @php $total += ($item['unit_price'] ?? 0) * ($item['quantity'] ?? 1); @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Total:</th>
                            <th class="text-end">${{ number_format($total, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
                <a href="{{ url('/customer/dashboard') }}" class="btn btn-burgundy mt-4">Back to Dashboard</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 