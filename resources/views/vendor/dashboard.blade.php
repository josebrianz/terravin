<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Dashboard | TERRAVIN</title>
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
        .dashboard-section {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
        }
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            color: var(--burgundy);
            font-weight: 600;
            margin-bottom: 1rem;
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
                            <li><a href="{{ url('/vendor/orders') }}" class="nav-link"><i class="fas fa-shopping-bag"></i> Orders</a></li>
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
            <h1 class="page-title mb-4">Vendor Dashboard</h1>
            <div class="dashboard-section">
                <div class="section-title"><i class="fas fa-shopping-bag me-2"></i>Orders</div>
                <p>View, confirm, update, and track orders assigned to you as a vendor.</p>
                <a href="{{ url('/vendor/orders') }}" class="btn btn-burgundy">Manage Orders</a>
            </div>
            <div class="dashboard-section">
                <div class="section-title"><i class="fas fa-boxes me-2"></i>Inventory</div>
                <p>View and manage your inventory, update stock levels, and add new products.</p>
                <a href="{{ url('/vendor/inventory') }}" class="btn btn-burgundy">View Inventory</a>
            </div>
            <div class="dashboard-section">
                <div class="section-title"><i class="fas fa-chart-line me-2"></i>Analytics</div>
                <p>View sales analytics, performance reports, and demand forecasts to optimize your operations.</p>
                <a href="{{ url('/reports') }}" class="btn btn-burgundy">View Analytics</a>
            </div>
            <div class="dashboard-section" style="background: linear-gradient(135deg, #f5f0e6 60%, #c8a97e 100%); box-shadow: 0 4px 20px rgba(94, 15, 15, 0.10); border: 2px solid #c8a97e;">
                <div class="section-title" style="font-size: 1.5rem; color: #5e0f0f;">
                    <i class="fas fa-truck-loading me-2 text-gold"></i>Bulk Order from Company
                </div>
                <p style="font-size: 1.1rem; color: #5e0f0f;">
                    Need to restock in large quantities? Place a creative bulk order directly from the company and enjoy special rates, priority processing, and seamless delivery for your business needs.
                </p>
                <a href="{{ url('/vendor/bulk-order') }}" class="btn btn-burgundy" style="font-size: 1.1rem; font-weight: 600; box-shadow: 0 2px 8px #c8a97e; transition: transform 0.2s;">
                    <i class="fas fa-wine-bottle me-2"></i>Place Bulk Order
                </a>
            </div>
            <div class="dashboard-section text-center" style="background: none; box-shadow: none; border: none; margin-top: -1rem;">
                <a href="{{ route('vendor.bulk-order.history') }}" class="btn btn-burgundy btn-lg mt-2 wine-track-btn" style="font-size: 1.25rem; font-weight: 700; border: 2px solid #c8a97e; color: #fff; box-shadow: 0 4px 16px rgba(94,15,15,0.12); letter-spacing: 1px;">
                    <i class="fas fa-history me-2"></i>Track Bulk Orders
                </a>
            </div>
            <style>
                .wine-track-btn {
                    background: linear-gradient(135deg, #5e0f0f 60%, #8b1a1a 100%);
                    border-radius: 2rem;
                    transition: background 0.2s, color 0.2s, box-shadow 0.2s;
                }
                .wine-track-btn:hover, .wine-track-btn:focus {
                    background: linear-gradient(135deg, #8b1a1a 60%, #5e0f0f 100%);
                    color: #c8a97e;
                    box-shadow: 0 8px 24px rgba(94,15,15,0.18);
                    text-decoration: none;
                }
            </style>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 