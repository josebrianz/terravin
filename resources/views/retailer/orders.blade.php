<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders | TERRAVIN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --burgundy: #5e0f0f;
            --light-burgundy: #8b1a1a;
            --gold: #c8a97e;
            --cream: #f5f0e6;
            --light-cream: #f9f5ed;
            --dark-text: #2a2a2a;
            --gray: #e1e5e9;
            --light-gray: #f8f9fa;
            --shadow-sm: 0 2px 8px rgba(94, 15, 15, 0.08);
            --shadow-md: 0 4px 20px rgba(94, 15, 15, 0.12);
            --transition: all 0.3s ease;
            --border-radius: 12px;
        }
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--light-cream);
            color: var(--dark-text);
            line-height: 1.6;
        }
        .wine-top-bar {
            background: linear-gradient(135deg, var(--burgundy) 0%, var(--light-burgundy) 100%);
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
            font-size: 1.5rem;
            font-weight: 700;
            transition: color 0.3s ease;
            margin-right: 1.5rem;
        }
        .wine-brand:hover {
            color: white;
            text-decoration: none;
        }
        .wine-nav .nav-links {
            gap: 1.5rem;
        }
        .nav-link {
            color: rgba(255, 255, 255, 0.92);
            text-decoration: none;
            padding: 0.5rem 1.1rem;
            border-radius: 20px;
            transition: all 0.2s;
            font-size: 1.05rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--gold);
            background: rgba(255,255,255,0.08);
        }
        .main-content {
            padding: 2rem 2.5rem;
            background-color: var(--light-gray);
            margin-top: 90px;
        }
        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            color: var(--burgundy);
            font-weight: 600;
        }
        .order-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(200, 169, 126, 0.2);
            margin-bottom: 1.5rem;
            padding: 1.5rem;
        }
        .order-table th, .order-table td {
            vertical-align: middle;
        }
        .order-status {
            font-weight: 600;
            border-radius: 1rem;
            padding: 0.3rem 1rem;
            font-size: 0.95rem;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-processing { background: #cce5ff; color: #004085; }
        .status-shipped { background: #d1ecf1; color: #0c5460; }
        .status-delivered { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <!-- Wine-themed top nav bar for retailer -->
    <div class="wine-top-bar">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between" style="min-height: 80px;">
                <div class="d-flex align-items-center gap-3">
                    <a class="wine-brand" href="{{ route('retailer.dashboard') }}">
                        <i class="fas fa-wine-bottle"></i>
                    </a>
                    <nav class="wine-nav">
                        <ul class="nav-links d-flex align-items-center gap-3 mb-0" style="list-style:none;">
                            <li><a href="{{ route('retailer.dashboard') }}" class="nav-link"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                            <li><a href="{{ route('retailer.orders') }}" class="nav-link active"><i class="fas fa-shopping-bag"></i> Orders</a></li>
                            <li><a href="{{ route('retailer.inventory') }}" class="nav-link"><i class="fas fa-boxes"></i> Inventory</a></li>
                            <li><a href="{{ route('retailer.catalog') }}" class="nav-link"><i class="fas fa-store"></i> Product Catalog</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="d-flex align-items-center gap-4">
                    <a href="{{ route('retailer.cart') }}" class="btn btn-outline-light position-relative">
                        <i class="fas fa-shopping-cart"></i>
                        @php
                            $cartCount = count(session()->get('retailer_cart', []));
                        @endphp
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                    <div class="dropdown">
                        <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="profile-photo-placeholder-large rounded-circle d-flex align-items-center justify-content-center me-2" style="border: 6px solid var(--gold); background: linear-gradient(135deg, var(--burgundy) 0%, #8b1a1a 100%); width: 72px; height: 72px; color: #fff; font-size: 2rem;">
                                <span class="fw-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                            <span class="user-name" style="color: #fff;">{{ Auth::user()->name }} <span class="text-gold" style="font-weight: 500; color: var(--gold);">(Retailer)</span></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user-edit me-2"></i> Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                        </ul>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </div>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div class="container-fluid">
            <h1 class="page-title mb-4">My Orders</h1>
            <!-- Orders Placed by Retailer (to Vendors) -->
            <div class="order-card mb-5">
                <h4 class="mb-3"><i class="fas fa-arrow-up me-2"></i>Orders Placed by You (to Vendors)</h4>
                <div class="table-responsive">
                    <table class="table order-table align-middle">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Date</th>
                                <th>Vendor</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Items</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ordersPlaced as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>{{ $order->vendor->name ?? 'Vendor' }}</td>
                                    <td><span class="order-status status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                                    <td>${{ number_format($order->total_amount, 2) }}</td>
                                    <td>
                                        @php
                                            $items = $order->items;
                                            if (is_string($items)) {
                                                $decoded = json_decode($items, true);
                                                // If still a string after first decode, decode again
                                                if (is_string($decoded)) {
                                                    $decoded = json_decode($decoded, true);
                                                }
                                                $items = is_array($decoded) ? $decoded : [];
                                            }
                                            $itemList = collect($items)->map(function($item) {
                                                $name = $item['wine_name'] ?? $item['item_name'] ?? 'Unnamed Item';
                                                $qty = isset($item['quantity']) ? $item['quantity'] : 1;
                                                return $name . ' x' . $qty;
                                            })->implode(', ');
                                        @endphp
                                        {{ $itemList ?: 'No items' }}
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted">No orders placed yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Orders Received by Retailer (from Customers) -->
            <div class="order-card">
                <h4 class="mb-3"><i class="fas fa-arrow-down me-2"></i>Orders Received from Customers</h4>
                <div class="table-responsive">
                    <table class="table order-table align-middle">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Items</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ordersReceived as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>{{ $order->user->name ?? 'Customer' }}</td>
                                    <td><span class="order-status status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                                    <td>${{ number_format($order->total_amount, 2) }}</td>
                                    <td>
                                        @php
                                            $items = $order->items;
                                            if (is_string($items)) {
                                                $decoded = json_decode($items, true);
                                                // If still a string after first decode, decode again
                                                if (is_string($decoded)) {
                                                    $decoded = json_decode($decoded, true);
                                                }
                                                $items = is_array($decoded) ? $decoded : [];
                                            }
                                            $itemList = collect($items)->map(function($item) {
                                                $name = $item['wine_name'] ?? $item['item_name'] ?? 'Unnamed Item';
                                                $qty = isset($item['quantity']) ? $item['quantity'] : 1;
                                                return $name . ' x' . $qty;
                                            })->implode(', ');
                                        @endphp
                                        {{ $itemList ?: 'No items' }}
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted">No orders received from customers yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 