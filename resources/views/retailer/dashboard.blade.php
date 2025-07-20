<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retailer Dashboard | TERRAVIN</title>
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
        .dashboard {
            width: 100vw;
            min-height: 100vh;
            display: block;
            margin-top: 70px;
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
        .user-profile {
            margin-top: auto;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }
        .user-avatar-sm {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--burgundy);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.2rem;
        }
        .main-content {
            padding: 2rem 2.5rem;
            background-color: var(--light-gray);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            color: var(--burgundy);
            font-weight: 600;
        }
        .page-subtitle {
            font-size: 0.9rem;
            color: #666;
            margin-top: 0.3rem;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }
        .stat-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: rgba(94, 15, 15, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--burgundy);
            font-size: 1.2rem;
        }
        .stat-content {
            flex: 1;
        }
        .stat-title {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.3rem;
        }
        .stat-value {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--burgundy);
            margin-bottom: 0.2rem;
        }
        .stat-change {
            font-size: 0.75rem;
            color: #4CAF50;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }
        .stat-change.negative {
            color: #F44336;
        }
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--burgundy);
            font-weight: 600;
        }
        .view-all {
            font-size: 0.9rem;
            color: var(--burgundy);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            transition: var(--transition);
        }
        .view-all:hover {
            color: var(--light-burgundy);
        }
        .view-all i {
            font-size: 0.8rem;
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
                            <li><a href="{{ route('inventory.index') }}" class="nav-link"><i class="fas fa-boxes"></i> Inventory</a></li>
                            <!-- <li><a href="{{ route('reports.index') }}" class="nav-link"><i class="fas fa-chart-line"></i> Reports</a></li> -->
                            <li><a href="{{ route('help.index') }}" class="nav-link"><i class="fas fa-question-circle"></i> Help</a></li>
                            <li><a href="{{ route('retailer.orders') }}" class="nav-link"><i class="fas fa-shopping-bag"></i> Orders</a></li>
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
    <div class="dashboard">
        <main class="main-content">
            <div class="header">
                <div class="greeting">
                    <!-- Remove the user-avatar-sm circle -->
                    <div>
                        <h1 class="page-title">Welcome back, {{ Auth::user()->name }}</h1>
                        <p class="page-subtitle">Here's what's happening with your retail account today</p>
                    </div>
                </div>
            </div>
            <!-- Stats Overview -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-title">Pending Orders</p>
                        <h3 class="stat-value">{{ $pendingOrders }}</h3>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-title">Low Inventory</p>
                        <h3 class="stat-value">{{ $lowInventory }}</h3>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-title">Notifications</p>
                        <h3 class="stat-value">{{ $notifications }}</h3>
                    </div>
                </div>
            </div>
            <!-- Quick Actions -->
            <div class="section-header">
                <h2 class="section-title">Quick Actions</h2>
        </div>
            <div class="d-flex flex-wrap gap-3 mb-4">
                        <a href="{{ route('orders.index') }}" class="btn btn-burgundy btn-lg shadow wine-action-btn"><i class="fas fa-shopping-bag me-2"></i> <span class="fw-bold">View Orders</span></a>

                        <a href="{{ route('inventory.index') }}" class="btn btn-gold btn-lg shadow wine-action-btn"><i class="fas fa-boxes me-2"></i> <span class="fw-bold">Inventory</span></a>
                        <!-- <a href="{{ route('reports.index') }}" class="btn btn-outline-gold btn-lg shadow wine-action-btn"><i class="fas fa-chart-line me-2"></i> <span class="fw-bold">Reports</span></a> -->

                        <a href="{{ route('retailer.inventory') }}" class="btn btn-gold btn-lg shadow wine-action-btn"><i class="fas fa-boxes me-2"></i> <span class="fw-bold">Inventory</span></a>

                    </div>
            <!-- Recent Orders & Top Products -->
            <div class="section-header">
                <h2 class="section-title">Recent Orders & Top Low Inventory Products</h2>
            </div>
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-bold text-burgundy"><i class="fas fa-shopping-bag text-gold me-2"></i> Recent Orders</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-0">
                            @forelse($recentOrders as $order)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Order #{{ $order->id }} - {{ $order->customer_name }}</span>
                                <span class="badge bg-info">{{ ucfirst($order->status) }}</span>
                            </li>
                            @empty
                            <li class="list-group-item text-muted">No recent orders</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-bold text-burgundy"><i class="fas fa-boxes text-gold me-2"></i> Top Low Inventory Products</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-0">
                            @forelse($topProducts as $product)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $product->name }}</span>
                                <span class="badge bg-warning text-dark">{{ $product->quantity }} left</span>
                            </li>
                            @empty
                            <li class="list-group-item text-muted">No low inventory products</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 