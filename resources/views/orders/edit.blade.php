<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order | TERRAVIN</title>
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
        .edit-order-box {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            padding: 2rem 2.5rem;
            max-width: 700px;
            margin: 2rem auto;
        }
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--burgundy);
            font-weight: 600;
        }
        .btn-burgundy {
            background: var(--burgundy);
            color: white;
            border: none;
            border-radius: 2rem;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            transition: var(--transition);
        }
        .btn-burgundy:hover {
            background: var(--light-burgundy);
            color: white;
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
                            <li><a href="{{ route('orders.index') }}" class="nav-link"><i class="fas fa-shopping-bag"></i> Orders</a></li>
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
                            <span class="user-name" style="font-family: 'Montserrat', sans-serif; font-size: 1.15rem; font-weight: 700; letter-spacing: 0.5px; color: #fff;">{{ Auth::user()->name }} <span class="text-gold" style="font-weight: 500;">(Retailer)</span></span>
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
        <div class="edit-order-box">
            <h2 class="section-title mb-4">Edit Order #{{ $order->id ?? '' }}</h2>
            <form method="POST" action="{{ route('orders.update', $order->id ?? 0) }}">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="customer_name" class="form-label">Customer Name *</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ old('customer_name', $order->customer_name ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="customer_email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="customer_email" name="customer_email" value="{{ old('customer_email', $order->customer_email ?? '') }}" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="customer_phone" class="form-label">Phone *</label>
                        <input type="text" class="form-control" id="customer_phone" name="customer_phone" value="{{ old('customer_phone', $order->customer_phone ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="shipping_address" class="form-label">Shipping Address *</label>
                        <input type="text" class="form-control" id="shipping_address" name="shipping_address" value="{{ old('shipping_address', $order->shipping_address ?? '') }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea class="form-control" id="notes" name="notes" rows="2">{{ old('notes', $order->notes ?? '') }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="form-label">Order Items</label>
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
                            @php
                                $items = is_array($order->items ?? null) ? $order->items : (json_decode($order->items ?? '[]', true) ?: []);
                                $total = 0;
                            @endphp
                            @foreach($items as $i => $item)
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" name="items[{{ $i }}][wine_name]" value="{{ $item['wine_name'] ?? $item['item_name'] ?? '' }}" required>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="items[{{ $i }}][quantity]" value="{{ $item['quantity'] ?? 1 }}" min="1" required>
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" class="form-control" name="items[{{ $i }}][unit_price]" value="{{ $item['unit_price'] ?? 0 }}" required>
                                    </td>
                                    <td>
                                        <span class="fw-bold">${{ number_format(($item['unit_price'] ?? 0) * ($item['quantity'] ?? 1), 2) }}</span>
                                    </td>
                                </tr>
                                @php $total += ($item['unit_price'] ?? 0) * ($item['quantity'] ?? 1); @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total:</th>
                                <th class="text-burgundy">${{ number_format($total, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                    <!-- Add/Remove item functionality can be added with JS if needed -->
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-burgundy px-4">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 