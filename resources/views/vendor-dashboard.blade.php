<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Dashboard | Terravin Wines</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Chart.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.css">
    <style>
        :root {
            --burgundy: #5e0f0f;
            --dark-burgundy: #4a0c0c;
            --gold: #c8a97e;
            --light-gold: #e4d5b7;
            --cream: #f5f0e6;
            --dark-text: #2a2a2a;
            --light-text: #f8f8f8;
            --transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--cream);
            color: var(--dark-text);
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.6;
        }
        
        /* Navigation */
        .navbar {
            background: linear-gradient(135deg, var(--burgundy), var(--dark-burgundy));
            color: var(--gold);
            padding: 0.5rem 2rem;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1000;
        }
        
        .brand-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .wine-icon {
            font-size: 1.8rem;
            color: var(--gold);
            transition: var(--transition);
        }
        
        .brand-text {
            display: flex;
            flex-direction: column;
        }
        
        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            color: var(--gold);
            letter-spacing: 0.8px;
            margin-bottom: 2px;
        }
        
        .brand-subtitle {
            font-size: 0.75rem;
            color: var(--light-gold);
            opacity: 0.9;
            letter-spacing: 0.5px;
        }
        
        .user-nav {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--gold);
        }
        
        .user-name {
            font-weight: 500;
            color: var(--light-text);
        }
        
        .logout-btn {
            background: transparent;
            color: var(--gold);
            border: 1px solid var(--gold);
            padding: 0.35rem 1rem;
            font-size: 0.85rem;
            border-radius: 20px;
            transition: var(--transition);
        }
        
        .logout-btn:hover {
            background: var(--gold);
            color: var(--burgundy);
        }
        
        /* Dashboard Header */
        .dashboard-header {
            background: linear-gradient(rgba(94, 15, 15, 0.9), rgba(94, 15, 15, 0.95)), 
                        url('https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: var(--gold);
            padding: 4rem 0 3rem 0;
            text-align: center;
            position: relative;
        }
        
        .dashboard-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            margin-bottom: 0.5rem;
            letter-spacing: 1.5px;
            font-weight: 600;
        }
        
        .dashboard-header .subtitle {
            font-size: 1.1rem;
            color: var(--light-gold);
            max-width: 700px;
            margin: 0 auto 1rem auto;
            opacity: 0.9;
        }
        
        .divider {
            width: 80px;
            height: 3px;
            background: var(--gold);
            margin: 1.5rem auto;
            border-radius: 2px;
        }
        
        /* Welcome Section */
        .welcome-section {
            max-width: 1200px;
            margin: -2rem auto 2rem auto;
            padding: 0 1.5rem;
        }
        
        .welcome-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 5px 25px rgba(94, 15, 15, 0.1);
            padding: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            position: relative;
            border-top: 4px solid var(--gold);
        }
        
        .welcome-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--gold);
            margin-bottom: 1.5rem;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
        }
        
        .welcome-title {
            font-family: 'Playfair Display', serif;
            color: var(--burgundy);
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .welcome-text {
            color: var(--dark-text);
            margin-bottom: 1.5rem;
            max-width: 600px;
        }
        
        .stats-container {
            display: flex;
            justify-content: space-around;
            width: 100%;
            margin: 1.5rem 0;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .stat-item {
            flex: 1;
            min-width: 150px;
            padding: 1rem;
            background: rgba(200, 169, 126, 0.1);
            border-radius: 8px;
            border-left: 3px solid var(--gold);
        }
        
        .stat-number {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            color: var(--burgundy);
            margin-bottom: 0.2rem;
        }
        
        .stat-label {
            font-size: 0.85rem;
            color: var(--dark-text);
            opacity: 0.8;
        }
        
        /* Dashboard Actions */
        .dashboard-actions {
            max-width: 1200px;
            margin: 2rem auto 3rem auto;
            padding: 0 1.5rem;
        }
        
        .section-title {
            font-family: 'Playfair Display', serif;
            color: var(--burgundy);
            font-size: 1.8rem;
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
        }
        
        .section-title:after {
            content: '';
            display: block;
            width: 60px;
            height: 2px;
            background: var(--gold);
            margin: 0.8rem auto;
        }
        
        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }
        
        .action-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(94, 15, 15, 0.08);
            padding: 2rem;
            text-align: center;
            transition: var(--transition);
            border-top: 3px solid transparent;
        }
        
        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(94, 15, 15, 0.12);
            border-top-color: var(--gold);
        }
        
        .action-icon {
            font-size: 2.2rem;
            color: var(--burgundy);
            margin-bottom: 1rem;
        }
        
        .action-card h3 {
            font-family: 'Playfair Display', serif;
            color: var(--burgundy);
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }
        
        .action-card p {
            color: var(--dark-text);
            opacity: 0.8;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }
        
        .action-btn {
            display: inline-block;
            background: transparent;
            color: var(--burgundy);
            border: 2px solid var(--gold);
            padding: 0.6rem 1.8rem;
            font-size: 0.9rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 30px;
            transition: var(--transition);
            text-decoration: none;
        }
        
        .action-btn:hover {
            background: var(--gold);
            color: var(--burgundy);
        }
        
        /* Data Visualization Section */
        .data-section {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }
        
        .chart-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 3px 15px rgba(94, 15, 15, 0.08);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .chart-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }
        
        .chart-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 3px 15px rgba(94, 15, 15, 0.08);
        }
        
        .chart-title {
            font-family: 'Playfair Display', serif;
            color: var(--burgundy);
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .hover-card {
            cursor: pointer;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        
        .hover-card:hover {
            box-shadow: 0 8px 25px rgba(94, 15, 15, 0.18);
            transform: translateY(-4px) scale(1.02);
        }
        
        /* Product Table Section */
        .product-section {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }
        
        .product-table {
            background: white;
            border-radius: 8px;
            box-shadow: 0 3px 15px rgba(94, 15, 15, 0.08);
            padding: 2rem;
        }
        
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .search-filter {
            display: flex;
            gap: 1rem;
        }
        
        .search-box {
            position: relative;
        }
        
        .search-box input {
            padding-left: 2.5rem;
            border-radius: 20px;
            border: 1px solid rgba(200, 169, 126, 0.5);
        }
        
        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gold);
        }
        
        .table-responsive {
            overflow-x: auto;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table thead th {
            font-weight: 600;
            color: var(--burgundy);
            border-bottom: 2px solid var(--gold);
            padding: 0.75rem 1rem;
            text-align: left;
        }
        
        .table tbody tr {
            border-bottom: 1px solid rgba(200, 169, 126, 0.2);
            transition: var(--transition);
        }
        
        .table tbody tr:hover {
            background-color: rgba(200, 169, 126, 0.05);
        }
        
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
        }
        
        .product-img {
            width: 50px;
            height: 50px;
            border-radius: 4px;
            object-fit: cover;
            border: 1px solid rgba(200, 169, 126, 0.3);
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .status-active {
            background-color: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }
        
        .status-draft {
            background-color: rgba(108, 117, 125, 0.1);
            color: #6c757d;
        }
        
        .status-low {
            background-color: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }
        
        .action-btns .btn {
            padding: 0.35rem 0.75rem;
            font-size: 0.85rem;
            margin-right: 0.5rem;
        }
        
        .btn-edit {
            background-color: rgba(200, 169, 126, 0.1);
            color: var(--burgundy);
            border: 1px solid var(--gold);
        }
        
        .btn-edit:hover {
            background-color: var(--gold);
            color: white;
        }
        
        .btn-delete {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }
        
        .btn-delete:hover {
            background-color: #dc3545;
            color: white;
        }
        
        .table-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
        }
        
        .pagination-info {
            font-size: 0.9rem;
            color: var(--dark-text);
            opacity: 0.8;
        }
        
        .pagination .page-item .page-link {
            color: var(--burgundy);
            border: 1px solid rgba(200, 169, 126, 0.3);
            margin: 0 0.25rem;
        }
        
        .pagination .page-item.active .page-link {
            background-color: var(--burgundy);
            border-color: var(--burgundy);
            color: white;
        }
        
        .add-product-btn {
            background: var(--gold);
            color: var(--burgundy);
            border: none;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            border-radius: 30px;
            transition: var(--transition);
        }
        
        .add-product-btn:hover {
            background: var(--dark-burgundy);
            color: var(--gold);
        }
        
        /* Notifications Section */
        .notifications-section {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }
        
        .notification-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 3px 15px rgba(94, 15, 15, 0.08);
            padding: 1.5rem 2rem;
        }
        
        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .notification-item {
            display: flex;
            align-items: flex-start;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(200, 169, 126, 0.3);
        }
        
        .notification-item:last-child {
            border-bottom: none;
        }
        
        .notification-icon {
            font-size: 1.2rem;
            color: var(--gold);
            margin-right: 1rem;
            margin-top: 3px;
        }
        
        .notification-content {
            flex: 1;
        }
        
        .notification-title {
            font-weight: 600;
            color: var(--burgundy);
            margin-bottom: 0.3rem;
        }
        
        .notification-time {
            font-size: 0.8rem;
            color: var(--dark-text);
            opacity: 0.7;
        }
        
        .view-all {
            text-align: right;
            margin-top: 1rem;
        }
        
        .view-all a {
            color: var(--gold);
            text-decoration: none;
            font-size: 0.9rem;
            transition: var(--transition);
        }
        
        .view-all a:hover {
            color: var(--burgundy);
            text-decoration: underline;
        }
        
        /* Footer */
        footer {
            background: linear-gradient(135deg, var(--burgundy), var(--dark-burgundy));
            color: var(--light-text);
            text-align: center;
            padding: 3rem 1rem 2rem 1rem;
            margin-top: 3rem;
        }
        
        .footer-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            color: var(--gold);
            margin-bottom: 0.5rem;
            letter-spacing: 1px;
        }
        
        .footer-divider {
            width: 50px;
            height: 2px;
            background: var(--gold);
            margin: 1rem auto;
            opacity: 0.6;
        }
        
        .footer-contact {
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            opacity: 0.9;
        }
        
        .footer-social {
            margin: 1.5rem 0;
        }
        
        .footer-social a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: rgba(200, 169, 126, 0.1);
            color: var(--gold);
            border-radius: 50%;
            margin: 0 8px;
            font-size: 1rem;
            transition: var(--transition);
            text-decoration: none;
        }
        
        .footer-social a:hover {
            background: var(--gold);
            color: var(--burgundy);
            transform: translateY(-3px);
        }
        
        .footer-copyright {
            font-size: 0.85rem;
            opacity: 0.8;
            margin-top: 1.5rem;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .chart-row {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .dashboard-header h1 {
                font-size: 2.2rem;
            }
            
            .dashboard-header .subtitle {
                font-size: 1rem;
                padding: 0 1rem;
            }
            
            .welcome-card {
                padding: 1.5rem;
            }
            
            .stats-container {
                flex-direction: column;
                gap: 1rem;
            }
            
            .stat-item {
                min-width: 100%;
            }
            
            .action-grid {
                grid-template-columns: 1fr;
            }
            
            .navbar {
                padding: 0.5rem 1rem;
            }
            
            .user-nav {
                gap: 1rem;
            }
            
            .table-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .search-filter {
                width: 100%;
                flex-direction: column;
            }
            
            .search-box {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <div class="brand-container">
                <i class="fas fa-wine-bottle wine-icon"></i>
                <div class="brand-text">
                    <div class="brand-name">Terravin Wines</div>
                    <div class="brand-subtitle">Vendor Dashboard</div>
                </div>
            </div>
            <div class="user-nav">
                <a href="/chat" class="d-flex align-items-center text-decoration-none me-3" style="color: var(--gold); font-weight: 500; transition: var(--transition);">
                    <i class="fas fa-comments me-1"></i> Chat
                </a>
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Vendor') }}&background=5e0f0f&color=c8a97e&size=128" 
                     alt="User Avatar" class="user-avatar">
                <span class="user-name">{{ Auth::user()->name ?? 'Vendor' }}</span>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1>Vendor Portal</h1>
        <div class="subtitle">Manage your products and sales with Terravin Wines</div>
        <div class="divider"></div>
    </div>

    <!-- Welcome Section -->
    <section class="welcome-section">
        <div class="welcome-card">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Vendor') }}&background=5e0f0f&color=c8a97e&size=128" 
                 alt="Vendor Avatar" class="welcome-avatar">
            <h2 class="welcome-title">Welcome, {{ Auth::user()->name ?? 'Vendor' }}</h2>
            <p class="welcome-text">Thank you for partnering with Terravin Wines. Here's an overview of your recent sales and product performance.</p>
            
            <div class="stats-container">
                <div class="stat-item">
                    <div class="stat-number">42</div>
                    <div class="stat-label">Active Products</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">$8,420</div>
                    <div class="stat-label">Monthly Revenue</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">128</div>
                    <div class="stat-label">New Orders</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">4.7★</div>
                    <div class="stat-label">Avg. Rating</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Data Visualization Section -->
    <section class="data-section">
        <h2 class="section-title">Sales Analytics</h2>
        <div class="chart-container">
            <div class="chart-row">
                <a href="/vendor-analytics/sales" class="text-decoration-none">
                    <div class="chart-card hover-card">
                        <h3 class="chart-title">Monthly Sales Performance</h3>
                        <canvas id="salesChart" height="250"></canvas>
                    </div>
                </a>
                <a href="/vendor-analytics/categories" class="text-decoration-none">
                    <div class="chart-card hover-card">
                        <h3 class="chart-title">Product Categories</h3>
                        <canvas id="categoryChart" height="250"></canvas>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Product Table Section -->
    <section class="product-section">
        <div class="product-table">
            <div class="table-header">
                <h2 class="section-title" style="text-align: left; margin: 0;">Your Products</h2>
                <div class="search-filter">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control" placeholder="Search products...">
                    </div>
                    <select class="form-select" style="width: 180px;">
                        <option>All Categories</option>
                        <option>Red Wine</option>
                        <option>White Wine</option>
                        <option>Sparkling</option>
                        <option>Dessert Wine</option>
                    </select>
                    <select class="form-select" style="width: 150px;">
                        <option>All Status</option>
                        <option>Active</option>
                        <option>Draft</option>
                        <option>Low Stock</option>
                    </select>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 50px;"></th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><img src="https://images.unsplash.com/photo-1558160074-4ac7d3cbb388?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" class="product-img"></td>
                            <td>Merlot Reserve 2019</td>
                            <td>Red Wine</td>
                            <td>$24.99</td>
                            <td>48</td>
                            <td><span class="status-badge status-active">Active</span></td>
                            <td class="action-btns">
                                <button class="btn btn-edit btn-sm"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-delete btn-sm"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="https://images.unsplash.com/photo-1510812431401-41e2f9c2696b?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" class="product-img"></td>
                            <td>Chardonnay Classic 2020</td>
                            <td>White Wine</td>
                            <td>$19.99</td>
                            <td>32</td>
                            <td><span class="status-badge status-active">Active</span></td>
                            <td class="action-btns">
                                <button class="btn btn-edit btn-sm"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-delete btn-sm"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="https://images.unsplash.com/photo-1506377247377-2a5b3b417ebb?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" class="product-img"></td>
                            <td>Cabernet Sauvignon 2018</td>
                            <td>Red Wine</td>
                            <td>$29.99</td>
                            <td>12</td>
                            <td><span class="status-badge status-low">Low Stock</span></td>
                            <td class="action-btns">
                                <button class="btn btn-edit btn-sm"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-delete btn-sm"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="https://images.unsplash.com/photo-1531384370597-8590413be50a?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" class="product-img"></td>
                            <td>Prosecco DOC</td>
                            <td>Sparkling</td>
                            <td>$16.99</td>
                            <td>64</td>
                            <td><span class="status-badge status-active">Active</span></td>
                            <td class="action-btns">
                                <button class="btn btn-edit btn-sm"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-delete btn-sm"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="https://images.unsplash.com/photo-1474722883778-792e7990302f?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80" class="product-img"></td>
                            <td>Ice Wine 2017</td>
                            <td>Dessert Wine</td>
                            <td>$39.99</td>
                            <td>8</td>
                            <td><span class="status-badge status-draft">Draft</span></td>
                            <td class="action-btns">
                                <button class="btn btn-edit btn-sm"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-delete btn-sm"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="table-footer">
                <div class="pagination-info">Showing 1 to 5 of 42 products</div>
                <div class="d-flex">
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm">
                            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                    <button class="add-product-btn ms-3">
                        <i class="fas fa-plus me-2"></i>Add Product
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Notifications Section -->
    <section class="notifications-section">
        <div class="notification-card">
            <div class="notification-header">
                <h2 class="section-title" style="text-align: left; margin: 0;">Recent Notifications</h2>
                <div class="view-all">
                    <a href="#">View All</a>
                </div>
            </div>
            
            <div class="notification-item">
                <div class="notification-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">New Order Received</div>
                    <p>Order #TV-2023-1052 for 6 bottles of Merlot Reserve has been placed.</p>
                    <div class="notification-time">45 minutes ago</div>
                </div>
            </div>
            
            <div class="notification-item">
                <div class="notification-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">New Product Review</div>
                    <p>Your Chardonnay Classic received a 5-star rating from customer.</p>
                    <div class="notification-time">3 hours ago</div>
                </div>
            </div>
            
            <div class="notification-item">
                <div class="notification-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">Low Stock Alert</div>
                    <p>Your Cabernet Sauvignon stock is running low (12 bottles remaining).</p>
                    <div class="notification-time">1 day ago</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-logo">Terravin Wines</div>
        <div class="footer-divider"></div>
        <div class="footer-contact">
            Plot 42 Lakeside Drive • Entebbe, Uganda<br>
            +256 41 423 5678 • vendors@terravin.ug
        </div>
        <div class="footer-social">
            <a href="#" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
            <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" title="Location"><i class="fas fa-map-marker-alt"></i></a>
        </div>
        <div class="footer-copyright">
            &copy; 2025 Terravin Wines. All rights reserved.
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    
    <script>
        // Sales Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Monthly Sales',
                    data: [3200, 4200, 5100, 4800, 5800, 6200, 7300],
                    backgroundColor: 'rgba(200, 169, 126, 0.2)',
                    borderColor: 'rgba(94, 15, 15, 0.8)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(94, 15, 15, 0.9)',
                        titleFont: {
                            family: 'Montserrat',
                            size: 14
                        },
                        bodyFont: {
                            family: 'Montserrat',
                            size: 12
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(200, 169, 126, 0.1)'
                        },
                        ticks: {
                            callback: function(value) {
                                return '$' + value;
                            }
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(200, 169, 126, 0.1)'
                        }
                    }
                }
            }
        });
        
        // Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Red Wine', 'White Wine', 'Sparkling', 'Dessert Wine'],
                datasets: [{
                    data: [45, 30, 15, 10],
                    backgroundColor: [
                        'rgba(94, 15, 15, 0.8)',
                        'rgba(200, 169, 126, 0.8)',
                        'rgba(245, 240, 230, 0.8)',
                        'rgba(74, 12, 12, 0.8)'
                    ],
                    borderColor: [
                        'rgba(94, 15, 15, 1)',
                        'rgba(200, 169, 126, 1)',
                        'rgba(245, 240, 230, 1)',
                        'rgba(74, 12, 12, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            font: {
                                family: 'Montserrat'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(94, 15, 15, 0.9)',
                        titleFont: {
                            family: 'Montserrat',
                            size: 14
                        },
                        bodyFont: {
                            family: 'Montserrat',
                            size: 12
                        },
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.raw + '%';
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        });
        
        // Dark mode toggle functionality
        const darkModeToggle = document.createElement('div');
        darkModeToggle.innerHTML = `
            <div class="form-check form-switch ms-3">
                <input class="form-check-input" type="checkbox" id="darkModeToggle">
                <label class="form-check-label" for="darkModeToggle" style="color: var(--gold);">
                    <i class="fas fa-moon"></i>
                </label>
            </div>
        `;
        document.querySelector('.user-nav').prepend(darkModeToggle);
        
        document.getElementById('darkModeToggle').addEventListener('change', function() {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', this.checked);
            
            // Update chart colors for dark mode
            if (this.checked) {
                salesChart.options.scales.x.grid.color = 'rgba(255, 255, 255, 0.1)';
                salesChart.options.scales.y.grid.color = 'rgba(255, 255, 255, 0.1)';
            } else {
                salesChart.options.scales.x.grid.color = 'rgba(200, 169, 126, 0.1)';
                salesChart.options.scales.y.grid.color = 'rgba(200, 169, 126, 0.1)';
            }
            salesChart.update();
        });
        
        // Check for saved dark mode preference
        if (localStorage.getItem('darkMode') === 'true') {
            document.getElementById('darkModeToggle').checked = true;
            document.body.classList.add('dark-mode');
        }
    </script>
</body>
</html>