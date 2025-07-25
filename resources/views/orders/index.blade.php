<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Orders | TERRAVIN</title>
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
        .user-name {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #fff;
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
        .order-table th, .order-table td {
            vertical-align: middle;
        }
        .order-table th {
            color: var(--burgundy);
            font-weight: 700;
        }
        .order-table td {
            color: var(--dark-text);
        }
        .badge-warning { background: #ffc107; color: #222; }
        .badge-success { background: #28a745; color: #fff; }
        .badge-danger { background: #dc3545; color: #fff; }
        .badge-info { background: #17a2b8; color: #fff; }
        .badge-secondary { background: #6c757d; color: #fff; }
        /* Hide large default pagination arrows if any remain */
        .pagination .page-link svg {
            display: none !important;
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

                        </ul>
                    </nav>
                </div>
                <div class="d-flex align-items-center gap-4">
                    <div class="dropdown">
                        <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="profile-photo-placeholder-large rounded-circle d-flex align-items-center justify-content-center me-2" style="border: 6px solid var(--gold); background: linear-gradient(135deg, var(--burgundy) 0%, #8b1a1a 100%); width: 72px; height: 72px; color: #fff; font-size: 2rem;">
                                <span class="fw-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                            <span class="user-name">{{ Auth::user()->name }} <span class="text-gold" style="font-weight: 500;">(Retailer)</span></span>
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="page-title mb-0">All Wine Orders</h1>
                <span class="badge bg-gold text-burgundy px-3 py-2">
                    <i class="fas fa-clock me-1"></i>
                    {{ now()->format('M d, Y') }}
                </span>
            </div>
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-list text-gold me-2"></i> Customer Orders
                    </h5>
                </div>
                <div class="card-body">
                    @if($customerOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 order-table">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-burgundy fw-bold">Order ID</th>
                                        <th class="text-burgundy fw-bold">Customer</th>
                                        <th class="text-burgundy fw-bold">Items</th>
                                        <th class="text-burgundy fw-bold">Total Amount</th>
                                        <th class="text-burgundy fw-bold">Status</th>
                                        <th class="text-burgundy fw-bold">Date</th>
                                        <th class="text-burgundy fw-bold">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customerOrders as $order)
                                        @if($order->user && $order->user->role === 'Customer')
                                            <tr class="wine-list-item">
                                                <td><strong class="text-burgundy">#{{ $order->id }}</strong></td>
                                                <td>
                                                    <div>
                                                        <strong class="text-burgundy">{{ $order->customer_name }}</strong><br>
                                                        <small class="text-muted">{{ $order->customer_email }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($order->orderItems && $order->orderItems->count() > 0)
                                                        @foreach($order->orderItems as $item)
                                                            @php
                                                                $product = \App\Models\Inventory::find($item->inventory_id);
                                                                $imgPath = $product && !empty($product->images) && is_array($product->images) && count($product->images) > 0
                                                                    ? (Str::startsWith($product->images[0], 'inventory_images/') ? asset('storage/' . $product->images[0]) : asset('wine_images/' . $product->images[0]))
                                                                    : null;
                                                            @endphp
                                                            <div class="small text-burgundy d-flex align-items-center mb-1">
                                                                @if($imgPath)
                                                                    <img src="{{ $imgPath }}" alt="{{ $item->item_name ?? 'Wine' }}" style="width: 24px; height: 24px; object-fit: cover; border-radius: 4px; margin-right: 6px;">
                                                                @else
                                                                    <i class="fas fa-wine-bottle me-1 text-gold"></i>
                                                                @endif
                                                                <span>{{ $item->item_name ?? $item->wine_name ?? 'Wine' }} ({{ $item->quantity }})</span>
                                                            </div>
                                                        @endforeach
                                                    @elseif(is_iterable($order->items) && count($order->items) > 0)
                                                        @foreach($order->items as $item)
                                                            <div class="small text-burgundy d-flex align-items-center mb-1">
                                                                <i class="fas fa-wine-bottle me-1 text-gold"></i>
                                                                <span>{{ $item['wine_name'] ?? 'Wine' }} ({{ $item['quantity'] ?? 1 }})</span>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <span class="text-muted">No items</span>
                                                    @endif
                                                </td>
                                                <td><strong class="text-burgundy">${{ number_format($order->total_amount, 2) }}</strong></td>
                                                <td>
                                                    @php
                                                        $statusColors = [
                                                            'pending' => 'badge-warning',
                                                            'processing' => 'badge-info',
                                                            'shipped' => 'badge-info',
                                                            'delivered' => 'badge-success',
                                                            'completed' => 'badge-secondary',
                                                            'cancelled' => 'badge-danger',
                                                        ];
                                                        $badgeClass = $statusColors[$order->status] ?? 'badge-secondary';
                                                    @endphp
                                                    <span class="badge {{ $badgeClass }}" style="font-size:1em; min-width: 100px; display: inline-block; text-align: center;">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                                <td><small class="text-muted">{{ $order->created_at->format('M d, Y') }}</small></td>
                                                <td>
                                                    <div class="btn-group btn-group-sm d-flex flex-nowrap" role="group" style="gap: 0.5rem;">
                                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-burgundy d-flex align-items-center justify-content-center" title="View order details">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('orders.edit', $order) }}" class="btn btn-outline-gold d-flex align-items-center justify-content-center" title="Edit order">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this order?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger d-flex align-items-center justify-content-center" title="Delete order">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($customerOrders->count() > 0)
                        <div class="d-flex justify-content-center mt-4">
                                {{ $customerOrders->links('pagination::bootstrap-4') }}
                        </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <div class="icon-circle bg-burgundy mx-auto mb-3">
                                <i class="fas fa-shopping-cart fa-2x text-gold"></i>
                            </div>
                            <h5 class="text-burgundy fw-bold">No customer orders found</h5>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-list text-gold me-2"></i> My Orders
                    </h5>
                </div>
                <div class="card-body">
                    @if($myOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 order-table">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-burgundy fw-bold">Order ID</th>
                                        <th class="text-burgundy fw-bold">Vendor</th>
                                        <th class="text-burgundy fw-bold">Items</th>
                                        <th class="text-burgundy fw-bold">Total Amount</th>
                                        <th class="text-burgundy fw-bold">Status</th>
                                        <th class="text-burgundy fw-bold">Date</th>
                                        <th class="text-burgundy fw-bold">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($myOrders as $order)
                                    <tr class="wine-list-item">
                                        <td><strong class="text-burgundy">#{{ $order->id }}</strong></td>
                                        <td>
                                            @php $vendor = $order->vendor; @endphp
                                            <div>
                                                <strong class="text-burgundy">{{ $vendor ? $vendor->name : 'N/A' }}</strong><br>
                                                <small class="text-muted">{{ $vendor ? $vendor->email : '' }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            @if($order->orderItems && $order->orderItems->count() > 0)
                                                @foreach($order->orderItems as $item)
                                                    @php
                                                        $product = \App\Models\Inventory::find($item->inventory_id);
                                                        $imgPath = $product && !empty($product->images) && is_array($product->images) && count($product->images) > 0
                                                            ? (Str::startsWith($product->images[0], 'inventory_images/') ? asset('storage/' . $product->images[0]) : asset('wine_images/' . $product->images[0]))
                                                            : null;
                                                    @endphp
                                                    <div class="small text-burgundy d-flex align-items-center mb-1">
                                                        @if($imgPath)
                                                            <img src="{{ $imgPath }}" alt="{{ $item->item_name ?? 'Wine' }}" style="width: 24px; height: 24px; object-fit: cover; border-radius: 4px; margin-right: 6px;">
                                                        @else
                                                            <i class="fas fa-wine-bottle me-1 text-gold"></i>
                                                        @endif
                                                        <span>{{ $item->item_name ?? $item->wine_name ?? 'Wine' }} ({{ $item->quantity }})</span>
                                                    </div>
                                                @endforeach
                                            @elseif(is_iterable($order->items) && count($order->items) > 0)
                                                @foreach($order->items as $item)
                                                    <div class="small text-burgundy d-flex align-items-center mb-1">
                                                        <i class="fas fa-wine-bottle me-1 text-gold"></i>
                                                        <span>{{ $item['wine_name'] ?? 'Wine' }} ({{ $item['quantity'] ?? 1 }})</span>
                                                    </div>
                                                @endforeach
                                            @else
                                                <span class="text-muted">No items</span>
                                            @endif
                                        </td>
                                        <td><strong class="text-burgundy">${{ number_format($order->total_amount, 2) }}</strong></td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'pending' => 'badge-warning',
                                                    'processing' => 'badge-info',
                                                    'shipped' => 'badge-info',
                                                    'delivered' => 'badge-success',
                                                    'completed' => 'badge-secondary',
                                                    'cancelled' => 'badge-danger',
                                                ];
                                                $badgeClass = $statusColors[$order->status] ?? 'badge-secondary';
                                            @endphp
                                            <span class="badge {{ $badgeClass }}" style="font-size:1em; min-width: 100px; display: inline-block; text-align: center;">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td><small class="text-muted">{{ $order->created_at->format('M d, Y') }}</small></td>
                                        <td>
                                            <div class="btn-group btn-group-sm d-flex flex-nowrap" role="group" style="gap: 0.5rem;">
                                                <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-burgundy d-flex align-items-center justify-content-center" title="View order details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('orders.edit', $order) }}" class="btn btn-outline-gold d-flex align-items-center justify-content-center" title="Edit order">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this order?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger d-flex align-items-center justify-content-center" title="Delete order">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($myOrders->count() > 0)
                        <div class="d-flex justify-content-center mt-4">
                                {{ $myOrders->links('pagination::bootstrap-4') }}
                        </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <div class="icon-circle bg-burgundy mx-auto mb-3">
                                <i class="fas fa-shopping-cart fa-2x text-gold"></i>
                            </div>
                            <h5 class="text-burgundy fw-bold">No orders found</h5>
                            <p class="text-muted">Start by creating your first wine order.</p>
                            <a href="{{ route('orders.create') }}" class="btn btn-burgundy">
                                <i class="fas fa-plus"></i> Create First Order
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 