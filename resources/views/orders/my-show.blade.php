<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details | TERRAVIN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --burgundy: #5e0f0f;
            --gold: #c8a97e;
            --cream: #f5f0e6;
            --light-cream: #f9f5ed;
            --dark-text: #2a2a2a;
            --border-radius: 12px;
        }
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--light-cream);
            color: var(--dark-text);
        }
        .wine-top-bar {
            background: linear-gradient(135deg, var(--burgundy) 0%, #8b1a1a 100%);
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
            color: var(--gold);
            text-decoration: none;
            font-size: 1.25rem;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        .wine-brand:hover {
            color: white;
            text-decoration: none;
        }
        .wine-nav {
            display: flex;
            justify-content: flex-start;
        }
        .nav-links {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 2.5rem;
            align-items: center;
        }
        .nav-link {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            padding: 0.5rem 0.75rem;
            border-radius: 20px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--gold);
            background-color: rgba(200, 169, 126, 0.1);
            text-decoration: none;
        }
        .user-info {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 1rem;
        }
        .user-name {
            font-weight: 500;
            color: var(--gold);
        }
        .dashboard {
            width: 100vw;
            min-height: 100vh;
            display: block;
            margin-top: 70px;
        }
        .main-content {
            padding: 2rem 0;
            background-color: var(--light-cream);
            min-height: 80vh;
        }
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--burgundy);
            font-weight: 600;
        }
        .order-card {
            background: #fff;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 8px rgba(94, 15, 15, 0.08);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .order-details-table th, .order-details-table td {
            vertical-align: middle;
        }
        .order-details-table th {
            color: var(--burgundy);
        }
        .order-details-table td {
            color: var(--dark-text);
        }
        .order-summary {
            background: var(--cream);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        .fw-bold { font-weight: 600 !important; }
        .text-burgundy { color: var(--burgundy) !important; }
        .badge-gold { background: var(--gold); color: var(--burgundy); }
        .btn-burgundy {
            background: var(--burgundy) !important;
            color: var(--gold) !important;
            border: 2px solid var(--gold) !important;
            border-radius: 2rem !important;
            font-weight: 700 !important;
            transition: background 0.2s, color 0.2s, border 0.2s;
        }
        .btn-burgundy:hover {
            background: var(--gold) !important;
            color: var(--burgundy) !important;
            border-color: var(--burgundy) !important;
        }
    </style>
</head>
<body>
    <!-- Wine-themed top nav bar for retailer -->
    <div class="wine-top-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <a class="wine-brand" href="{{ route('retailer.dashboard') }}">
                        <i class="fas fa-wine-bottle"></i>
                    </a>
                </div>
                <div class="col-md-7">
                    <nav class="wine-nav">
                        <ul class="nav-links">
                            <li><a href="{{ route('retailer.dashboard') }}" class="nav-link"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                            <li><a href="{{ route('orders.index') }}" class="nav-link"><i class="fas fa-shopping-bag"></i> Orders</a></li>
                            <li><a href="{{ route('retailer.inventory') }}" class="nav-link"><i class="fas fa-boxes"></i> Inventory</a></li>
                            <li><a href="{{ route('retailer.catalog') }}" class="nav-link"><i class="fas fa-store"></i> Product Catalog</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-3 text-end">
                    <div class="user-info">
                        @auth
                        <div class="dropdown">
                            <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#" role="button" data-bs-toggle="dropdown">
                                @if(Auth::user()->profile_photo)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}?v={{ time() }}" alt="{{ Auth::user()->name }}" class="rounded-circle me-2" style="width: 48px; height: 48px; object-fit: cover; border: 3px solid var(--gold);">
                                @else
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 48px; height: 48px; border: 3px solid var(--gold); background: linear-gradient(135deg, var(--burgundy) 0%, #8b1a1a 100%);">
                                        <span class="text-white fw-bold" style="font-size: 20px;">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
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
    </div>

    <div class="dashboard">
        <main class="main-content container">
            <div class="section-header">
                <h2 class="section-title">Order #{{ $order->id }}</h2>
                <a href="{{ route('orders.index') }}" class="btn btn-burgundy btn-lg fw-bold shadow-sm" style="background: var(--burgundy); color: var(--gold); border: 2px solid var(--gold); border-radius: 2rem; padding: 0.75rem 2rem; font-size: 1.1rem;">
                    <i class="fas fa-arrow-left"></i> Back to Orders
                </a>
            </div>
            <div class="order-card mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="fw-bold text-burgundy mb-3"><i class="fas fa-user me-2"></i> Vendor Information</h5>
                        @php $vendor = $order->vendor; @endphp
                        <div class="mb-2"><span class="fw-bold">Name:</span> {{ $vendor ? $vendor->name : 'N/A' }}</div>
                        <div class="mb-2"><span class="fw-bold">Email:</span> {{ $vendor ? $vendor->email : 'N/A' }}</div>
                    </div>
                    <div class="col-md-6">
                        <h5 class="fw-bold text-burgundy mb-3"><i class="fas fa-info-circle me-2"></i> Order Details</h5>
                        <div class="mb-2"><span class="fw-bold">Status:</span> {{ ucfirst($order->status ?? '-') }}</div>
                        <div class="mb-2"><span class="fw-bold">Total Amount:</span> ${{ number_format($order->total_amount, 2) }}</div>
                        <div class="mb-2"><span class="fw-bold">Created At:</span> {{ $order->created_at->format('M d, Y') }}</div>
                        <div class="mb-2"><span class="fw-bold">Updated At:</span> {{ $order->updated_at->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>
            <div class="order-card">
                <h5 class="fw-bold text-burgundy mb-3"><i class="fas fa-boxes me-2"></i> Order Items</h5>
                <div class="table-responsive">
                    <table class="table order-details-table align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Wine Name</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $orderItems = is_array($order->items) ? $order->items : (json_decode($order->items, true) ?: []);
                            @endphp
                            @foreach($orderItems as $item)
                            <tr>
                                <td>{{ $item['wine_name'] ?? $item['item_name'] ?? '-' }}</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>${{ number_format($item['unit_price'], 2) }}</td>
                                <td>${{ number_format($item['unit_price'] * $item['quantity'], 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 