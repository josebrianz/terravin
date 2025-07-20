<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders from Retailers | TERRAVIN</title>
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
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="page-header border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between">
                        <div>
                            <h1 class="page-title mb-0 fw-bold text-burgundy">
                                <i class="fas fa-truck-loading me-2 text-gold"></i>
                                Orders from Retailers
                            </h1>
                            <span class="text-muted small">Manage and track all orders placed by retailers to you (the vendor).</span>
                        </div>
                        <div class="header-actions">
                            <span class="badge" style="background: var(--burgundy); color: var(--gold); border-radius: 1.5rem; padding: 0.8em 1.5em; font-size: 1.1em; box-shadow: 0 2px 8px rgba(94,15,15,0.10);">
                                <i class="fas fa-calendar-alt me-2"></i>{{ now()->format('M d, Y H:i') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Statistics Cards -->
            <div class="row g-4 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="card wine-card shadow-sm border-0">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <div class="icon-circle bg-burgundy">
                                    <i class="fas fa-truck-loading fa-2x text-gold"></i>
                                </div>
                            </div>
                            <h3 class="text-burgundy fw-bold mb-1">{{ number_format($orders->total()) }}</h3>
                            <p class="text-muted small mb-0">Total Retailer Orders</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card wine-card shadow-sm border-0">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <div class="icon-circle bg-warning">
                                    <i class="fas fa-clock fa-2x text-white"></i>
                                </div>
                            </div>
                            <h3 class="text-burgundy fw-bold mb-1">{{ number_format($orders->where('status', 'pending')->count()) }}</h3>
                            <p class="text-muted small mb-0">Pending Retailer Orders</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card wine-card shadow-sm border-0">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <div class="icon-circle bg-success">
                                    <i class="fas fa-check-circle fa-2x text-white"></i>
                                </div>
                            </div>
                            <h3 class="text-burgundy fw-bold mb-1">{{ number_format($orders->where('status', 'delivered')->count()) }}</h3>
                            <p class="text-muted small mb-0">Delivered Retailer Orders</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card wine-card shadow-sm border-0">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <div class="icon-circle bg-gold">
                                    <i class="fas fa-dollar-sign fa-2x text-burgundy"></i>
                                </div>
                            </div>
                            <h3 class="text-burgundy fw-bold mb-1">${{ number_format($orders->sum('total_amount'), 2) }}</h3>
                            <p class="text-muted small mb-0">Total Retailer Revenue</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Filters and Search -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card wine-card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom-0">
                            <h5 class="card-title mb-0 fw-bold text-burgundy">
                                <i class="fas fa-filter text-gold me-2"></i> Filters & Search
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="">All Statuses</option>
                                        <option value="pending" @if(request('status')=='pending') selected @endif>Pending</option>
                                        <option value="processing" @if(request('status')=='processing') selected @endif>Processing</option>
                                        <option value="shipped" @if(request('status')=='shipped') selected @endif>Shipped</option>
                                        <option value="delivered" @if(request('status')=='delivered') selected @endif>Delivered</option>
                                        <option value="cancelled" @if(request('status')=='cancelled') selected @endif>Cancelled</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Retailer Name</label>
                                    <input type="text" name="customer_name" class="form-control" value="{{ request('customer_name') }}" placeholder="Search by retailer name">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Retailer Email</label>
                                    <input type="email" name="customer_email" class="form-control" value="{{ request('customer_email') }}" placeholder="Search by retailer email">
                                </div>
                                <div class="col-12">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-burgundy">
                                            <i class="fas fa-search me-1"></i> Apply Filters
                                        </button>
                                        <a href="{{ url('/vendor/orders') }}" class="btn btn-outline-burgundy">
                                            <i class="fas fa-times me-1"></i> Clear Filters
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main Content -->
            <div class="row">
                <div class="col-12">
                    <div class="card wine-card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0 fw-bold text-burgundy">
                                <i class="fas fa-list text-gold me-2"></i> Retailer Orders ({{ $orders->total() }})
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Retailer</th>
                                            <th>Email</th>
                                            <th>Items</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($orders as $order)
                                        <tr>
                                            <td><span class="fw-bold text-burgundy">#{{ $order->id }}</span></td>
                                            <td>{{ $order->customer_name }}</td>
                                            <td><small class="text-muted">{{ $order->customer_email }}</small></td>
                                            <td>
                                                @php
                                                    $items = is_array($order->items) ? $order->items : json_decode($order->items, true);
                                                    $itemCount = is_array($items) ? count($items) : 0;
                                                @endphp
                                                <span class="badge bg-light text-dark">{{ $itemCount }} items</span>
                                            </td>
                                            <td><span class="fw-bold text-success">${{ number_format($order->total_amount, 2) }}</span></td>
                                            <td>
                                                @switch($order->status)
                                                    @case('pending')
                                                        <span class="badge bg-warning text-dark">Pending</span>
                                                        @break
                                                    @case('processing')
                                                        <span class="badge bg-info text-white">Processing</span>
                                                        @break
                                                    @case('shipped')
                                                        <span class="badge bg-primary text-white">Shipped</span>
                                                        @break
                                                    @case('delivered')
                                                        <span class="badge bg-success text-white">Delivered</span>
                                                        @break
                                                    @case('cancelled')
                                                        <span class="badge bg-danger text-white">Cancelled</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary text-white">{{ ucfirst($order->status) }}</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                <span class="badge" style="background: var(--burgundy); color: var(--gold); border-radius: 1rem; padding: 0.5em 1em; font-size: 0.95em;">
                                                    <i class="fas fa-calendar-alt me-1"></i>{{ $order->created_at->format('M d, Y') }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('vendor.orders.show', $order) }}" class="btn btn-outline-burgundy" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('vendor.orders.edit', $order) }}" class="btn btn-outline-gold" title="Edit Order">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">No orders from retailers found.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-white py-3">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 