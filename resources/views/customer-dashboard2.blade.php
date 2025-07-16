<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | TERRAVIN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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
            margin-top: 70px; /* Height of the fixed nav bar */
        }

        /* Sidebar - Modernized */
        .sidebar {
            background: var(--burgundy);
            color: white;
            padding: 2rem 1.5rem;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--gold);
            margin-bottom: 2.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(200, 169, 126, 0.2);
        }

        .logo i {
            font-size: 1.5rem;
        }

        .nav-menu {
            list-style: none;
            margin-top: 1rem;
            flex-grow: 1;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.8rem 1rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: var(--border-radius);
            transition: var(--transition);
            font-size: 0.95rem;
        }

        .nav-link:hover, .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .nav-link.active {
            background: linear-gradient(90deg, rgba(200, 169, 126, 0.2) 0%, rgba(94, 15, 15, 0) 100%);
            border-left: 3px solid var(--gold);
        }

        .nav-link i {
            font-size: 1rem;
            width: 24px;
            text-align: center;
            color: var(--gold);
        }

        .user-profile {
            margin-top: auto;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background-color: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--burgundy);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-info h4 {
            font-size: 0.95rem;
            margin-bottom: 0.2rem;
            font-weight: 500;
        }

        .user-info p {
            font-size: 0.75rem;
            opacity: 0.7;
        }

        /* Main Content - Modernized */
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

        .greeting {
            display: flex;
            align-items: center;
            gap: 1rem;
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

        .search-cart {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .search-bar {
            position: relative;
        }

        .search-bar input {
            padding: 0.8rem 1rem 0.8rem 2.5rem;
            border: 1px solid var(--gray);
            border-radius: var(--border-radius);
            width: 250px;
            font-family: inherit;
            background-color: white;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .search-bar input:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 0 2px rgba(200, 169, 126, 0.2);
        }

        .search-bar i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--burgundy);
            font-size: 0.9rem;
        }

        .cart-btn {
            background: var(--burgundy);
            color: white;
            border: none;
            width: 42px;
            height: 42px;
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
        }

        .cart-btn:hover {
            background: var(--light-burgundy);
            transform: translateY(-2px);
        }

        .cart-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--gold);
            color: var(--burgundy);
            width: 20px;
            height: 20px;
            border-radius: 50%;
            font-size: 0.7rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Dashboard Cards */
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

        /* Featured Section */
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

        /* Wine Grid - Modernized */
        .wine-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .wine-card {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
        }

        .wine-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .wine-image {
            height: 200px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .wine-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: var(--gold);
            color: var(--burgundy);
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .wine-details {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .wine-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color: var(--burgundy);
        }

        .wine-region {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .wine-region i {
            color: var(--gold);
            font-size: 0.8rem;
        }

        .wine-description {
            font-size: 0.85rem;
            margin-bottom: 1.2rem;
            color: #555;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex: 1;
        }

        .wine-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
        }

        .wine-price {
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--burgundy);
        }

        .add-to-cart {
            background: var(--burgundy);
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
        }

        .add-to-cart:hover {
            background: var(--light-burgundy);
            transform: translateY(-2px);
        }

        /* Recent Activity */
        .activity-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            margin-bottom: 2rem;
        }

        .activity-item {
            display: flex;
            gap: 1rem;
            padding: 0.8rem 0;
            border-bottom: 1px solid var(--gray);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(94, 15, 15, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--burgundy);
            font-size: 1rem;
            flex-shrink: 0;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 500;
            margin-bottom: 0.2rem;
            font-size: 0.95rem;
        }

        .activity-description {
            font-size: 0.85rem;
            color: #666;
        }

        .activity-time {
            font-size: 0.75rem;
            color: #999;
            margin-top: 0.3rem;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .dashboard {
                grid-template-columns: 240px 1fr;
            }
        }

        @media (max-width: 992px) {
            .dashboard {
                grid-template-columns: 1fr;
            }

            .sidebar {
                height: auto;
                position: static;
                padding: 1.5rem;
            }

            .nav-menu {
                display: flex;
                gap: 0.5rem;
                overflow-x: auto;
                padding-bottom: 1rem;
                margin-top: 0;
            }

            .nav-item {
                margin-bottom: 0;
            }

            .nav-link {
                white-space: nowrap;
            }

            .user-profile {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1.5rem;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .search-cart {
                width: 100%;
                justify-content: space-between;
            }

            .search-bar input {
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .wine-grid {
                grid-template-columns: 1fr;
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
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
        .nav-link:hover {
            color: var(--gold);
            background-color: rgba(200, 169, 126, 0.1);
            text-decoration: none;
        }
        .nav-link.active {
            color: var(--gold);
            background-color: rgba(200, 169, 126, 0.2);
        }
        .nav-link i {
            font-size: 0.8rem;
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
        .dropdown-menu {
            min-width: 180px;
        }
    </style>
</head>
<body>
    <!-- Wine-themed top nav bar for customer -->
    <div class="wine-top-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <a class="wine-brand" href="{{ route('customer.dashboard') }}">
                        <i class="fas fa-wine-bottle"></i>
                    </a>
                </div>
                <div class="col-md-7">
                    <nav class="wine-nav">
                        <ul class="nav-links">
                            <li><a href="{{ route('customer.dashboard') }}" class="nav-link"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                            <li><a href="{{ route('customer.products') }}" class="nav-link"><i class="fas fa-shopping-bag"></i> Wine Shop</a></li>
                            <li><a href="{{ route('customer.favorites') }}" class="nav-link"><i class="fas fa-heart"></i> Favorites</a></li>
                            <li><a href="{{ route('customer.orders') }}" class="nav-link"><i class="fas fa-history"></i> Orders</a></li>
                            <li><a href="{{ route('help.index') }}" class="nav-link"><i class="fas fa-question-circle"></i> Help</a></li>
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
        {{-- Sidebar removed --}}

        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <div class="greeting">
                    <div class="user-avatar-sm">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    <div>
                        <h1 class="page-title">Welcome back, {{ Auth::user()->name }}</h1>
                        <p class="page-subtitle">Here's what's happening with your account today</p>
                    </div>
                </div>
                <div class="search-cart">
                    <div class="search-bar">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search wines...">
                    </div>
                    {{-- <button class="cart-btn" onclick="window.location='{{ route('cart.index') }}'">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count">
                            {{ \App\Models\CartItem::where('user_id', Auth::id())->sum('quantity') }}
                        </span>
                    </button> --}}
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-title">Total Orders</p>
                        <h3 class="stat-value">{{ \App\Models\Order::where('customer_email', Auth::user()->email)->count() }}</h3>
                        <p class="stat-change">
                            <i class="fas fa-arrow-up"></i> 12% from last month
                        </p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-title">Favorites</p>
                        <h3 class="stat-value">8</h3>
                        <p class="stat-change">
                            <i class="fas fa-arrow-up"></i> 2 new this week
                        </p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-title">Member Level</p>
                        <h3 class="stat-value">Gold</h3>
                        <p class="stat-change">
                            <i class="fas fa-award"></i> 150 points to Platinum
                        </p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-wine-bottle"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-title">Wines Tasted</p>
                        <h3 class="stat-value">24</h3>
                        <p class="stat-change negative">
                            <i class="fas fa-arrow-down"></i> Time to restock!
                        </p>
                    </div>
                </div>
            </div>

            <!-- Featured Wines -->
            <div class="section-header">
                <h2 class="section-title">Featured Wines</h2>
                <a href="{{ route('customer.products') }}" class="view-all">
                    View all <i class="fas fa-chevron-right"></i>
                </a>
            </div>
            
            <div class="wine-grid">
                @foreach(\App\Models\Inventory::where('is_active', true)->inRandomOrder()->take(4)->get() as $wine)
                <div class="wine-card">
                    <div class="wine-image" style="background-image: url('{{ $wine->images && count($wine->images) > 0 ? asset('storage/' . $wine->images[0]) : 'https://via.placeholder.com/300x200?text=Wine' }}');">
                        <span class="wine-badge">Limited</span>
                    </div>
                    <div class="wine-details">
                        <h3 class="wine-name">{{ $wine->name }}</h3>
                        <p class="wine-region">
                            <i class="fas fa-map-marker-alt"></i> {{ $wine->region ?? 'Napa Valley' }}
                        </p>
                        <p class="wine-description">
                            {{ $wine->description ?? 'A premium selection with rich flavors and elegant finish. Perfect for special occasions.' }}
                        </p>
                        <div class="wine-footer">
                            <span class="wine-price">{{ format_usd($wine->unit_price) }}</span>
                            <button class="add-to-cart">
                                <i class="fas fa-plus"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Recent Activity -->
            <div class="section-header">
                <h2 class="section-title">Recent Activity</h2>
                <a href="{{ route('customer.orders') }}" class="view-all">
                    View all <i class="fas fa-chevron-right"></i>
                </a>
            </div>
            
            <div class="activity-card">
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <div class="activity-content">
                        <h4 class="activity-title">Order Shipped</h4>
                        <p class="activity-description">Your order #TRV-2023-056 has been shipped and will arrive in 2 days.</p>
                        <p class="activity-time">2 hours ago</p>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-wine-bottle"></i>
                    </div>
                    <div class="activity-content">
                        <h4 class="activity-title">New Collection Added</h4>
                        <p class="activity-description">Check out our new Italian red wine collection just arrived this week.</p>
                        <p class="activity-time">1 day ago</p>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-tag"></i>
                    </div>
                    <div class="activity-content">
                        <h4 class="activity-title">Special Offer</h4>
                        <p class="activity-description">Exclusive 15% discount for Gold members this weekend only.</p>
                        <p class="activity-time">3 days ago</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add to cart buttons
            const addToCartButtons = document.querySelectorAll('.add-to-cart');
            addToCartButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const wineCard = this.closest('.wine-card');
                    const wineName = wineCard.querySelector('.wine-name').textContent;
                    const winePrice = wineCard.querySelector('.wine-price').textContent;
                    
                    // Update cart count
                    const cartCount = document.querySelector('.cart-count');
                    let currentCount = parseInt(cartCount.textContent);
                    cartCount.textContent = currentCount + 1;
                    
                    // Visual feedback
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-check"></i> Added';
                    this.style.backgroundColor = '#4CAF50';
                    
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.style.backgroundColor = '';
                    }, 2000);
                    
                    // Notification
                    showNotification(`${wineName} added to cart`);
                });
            });

            // Show notification function
            function showNotification(message) {
                const notification = document.createElement('div');
                notification.className = 'notification';
                notification.innerHTML = `
                    <div class="notification-content">
                        <i class="fas fa-check-circle"></i>
                        <span>${message}</span>
                    </div>
                `;
                
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.classList.add('show');
                }, 10);
                
                setTimeout(() => {
                    notification.classList.remove('show');
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 300);
                }, 3000);
            }

            // Add notification styles dynamically
            const style = document.createElement('style');
            style.textContent = `
                .notification {
                    position: fixed;
                    bottom: 20px;
                    right: 20px;
                    background: var(--burgundy);
                    color: white;
                    padding: 15px 20px;
                    border-radius: var(--border-radius);
                    box-shadow: var(--shadow-md);
                    transform: translateY(100px);
                    opacity: 0;
                    transition: all 0.3s ease;
                    z-index: 1000;
                }
                .notification.show {
                    transform: translateY(0);
                    opacity: 1;
                }
                .notification-content {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                }
                .notification i {
                    font-size: 1.2rem;
                    color: var(--gold);
                }
            `;
            document.head.appendChild(style);
        });
    </script>
</body>
</html>