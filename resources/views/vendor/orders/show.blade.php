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
        .order-details-box {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            padding: 2rem 2.5rem;
            max-width: 900px;
            margin: 2rem auto;
        }
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--burgundy);
            font-weight: 600;
        }
        .badge-status {
            font-size: 1em;
            padding: 0.5em 1em;
            border-radius: 1rem;
        }
        .order-items-table th, .order-items-table td {
            vertical-align: middle;
        }
        .order-items-table th {
            color: var(--burgundy);
            font-weight: 700;
        }
        .order-items-table td {
            color: var(--dark-text);
        }
    </style>
</head>
<body>
    <!-- Wine-themed top nav bar for vendor -->
    <div class="wine-top-bar">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between" style="min-height: 80px;">
                <div class="d-flex align-items-center gap-3">
                    <a class="wine-brand" href="{{ url('/vendor/dashboard') }}">
                        <i class="fas fa-wine-bottle"></i>
                    </a>
                    <nav class="wine-nav">
                        <ul class="nav-links d-flex align-items-center gap-3 mb-0" style="list-style:none;">
                            <li><a href="{{ url('/vendor/dashboard') }}" class="nav-link"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                            <li><a href="{{ url('/vendor/orders') }}" class="nav-link active"><i class="fas fa-shopping-bag"></i> Orders</a></li>
                            <li><a href="{{ url('/vendor/inventory') }}" class="nav-link"><i class="fas fa-boxes"></i> Inventory</a></li>
                            <li><a href="{{ url('/reports') }}" class="nav-link"><i class="fas fa-chart-line"></i> Analytics</a></li>
                            <li><a href="{{ url('/vendor/bulk-order') }}" class="nav-link"><i class="fas fa-wine-bottle"></i> Bulk Order</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="d-flex align-items-center gap-4">
                    <div class="dropdown">
                        <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="profile-photo-placeholder-large rounded-circle d-flex align-items-center justify-content-center me-2" style="border: 6px solid var(--gold); background: linear-gradient(135deg, var(--burgundy) 0%, #8b1a1a 100%); width: 72px; height: 72px; color: #fff; font-size: 2rem;">
                                <span class="fw-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                            <span class="user-name">{{ Auth::user()->name }} <span class="text-gold" style="font-weight: 500;">(Vendor)</span></span>
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
        <div class="container-fluid px-0">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10 col-xl-9">
                    <div class="order-details-box" style="max-width:100%; width:100%;">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="section-title mb-0">Order #{{ $order->id }}</h2>
                            <a href="{{ route('vendor.orders.edit', $order) }}" class="btn btn-outline-gold"><i class="fas fa-edit me-1"></i> Edit Order</a>
                        </div>
                        <div class="mb-3">
                            <span class="badge badge-status 
                                @switch($order->status)
                                    @case('pending') bg-warning text-dark @break
                                    @case('processing') bg-info text-white @break
                                    @case('shipped') bg-primary text-white @break
                                    @case('delivered') bg-success text-white @break
                                    @case('cancelled') bg-danger text-white @break
                                    @default bg-secondary text-white
                                @endswitch
                            ">
                                {{ ucfirst($order->status) }}
                            </span>
                            <span class="ms-3 text-muted"><i class="fas fa-calendar-alt me-1"></i> {{ $order->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="fw-bold text-burgundy">Retailer Info</h5>
                                <ul class="list-unstyled mb-0">
                                    <li><strong>Name:</strong> {{ $order->customer_name }}</li>
                                    <li><strong>Email:</strong> {{ $order->customer_email }}</li>
                                    <li><strong>Phone:</strong> {{ $order->customer_phone }}</li>
                                    <li><strong>Shipping Address:</strong> {{ $order->shipping_address }}</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold text-burgundy">Order Summary</h5>
                                <ul class="list-unstyled mb-0">
                                    <li><strong>Total:</strong> ${{ number_format($order->total_amount, 2) }}</li>
                                    <li><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</li>
                                    <li><strong>Notes:</strong> {{ $order->notes ?: '-' }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h5 class="fw-bold text-burgundy mb-3">Order Items</h5>
                            <table class="table order-items-table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0; @endphp
                                    @foreach($order->orderItems as $item)
                                        <tr>
                                            <td>{{ $item->item_name ?? $item->wine_name ?? '-' }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>${{ number_format($item->unit_price, 2) }}</td>
                                            <td>${{ number_format($item->unit_price * $item->quantity, 2) }}</td>
                                        </tr>
                                        @php $total += $item->unit_price * $item->quantity; @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end">Total:</th>
                                        <th class="text-burgundy">${{ number_format($total, 2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('vendor.orders.index') }}" class="btn btn-burgundy"><i class="fas fa-arrow-left me-1"></i> Back to Orders</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 