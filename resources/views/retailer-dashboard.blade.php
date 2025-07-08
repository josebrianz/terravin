<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retailer Dashboard | Terravin Wines</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --info: #17a2b8;
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
            transition: var(--transition);
        }
        .stat-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(94, 15, 15, 0.1);
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
            display: flex;
            flex-direction: column;
            height: 100%;
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
            flex-grow: 1;
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
            align-self: center;
        }
        .action-btn:hover {
            background: var(--gold);
            color: var(--burgundy);
        }
        .dashboard-content {
            max-width: 1200px;
            margin: 0 auto 3rem auto;
            padding: 0 1.5rem;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }
        @media (max-width: 992px) {
            .dashboard-content {
                grid-template-columns: 1fr;
            }
        }
        .main-content {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }
        .chart-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(94, 15, 15, 0.08);
            padding: 1.5rem;
        }
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
        .orders-table {
            width: 100%;
            border-collapse: collapse;
        }
        .orders-table th {
            text-align: left;
            padding: 0.75rem 1rem;
            background: rgba(94, 15, 15, 0.05);
            font-weight: 600;
            color: var(--burgundy);
        }
        .orders-table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid rgba(200, 169, 126, 0.2);
        }
        .orders-table tr:last-child td {
            border-bottom: none;
        }
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .status-pending {
            background-color: rgba(255, 193, 7, 0.1);
            color: #b58a00;
        }
        .status-processing {
            background-color: rgba(23, 162, 184, 0.1);
            color: #0d6e7c;
        }
        .status-shipped {
            background-color: rgba(40, 167, 69, 0.1);
            color: #1e7e34;
        }
        .status-delivered {
            background-color: rgba(108, 117, 125, 0.1);
            color: #495057;
        }
        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }
        .notification-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(94, 15, 15, 0.08);
            padding: 1.5rem;
        }
        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
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
        .promo-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(94, 15, 15, 0.08);
            padding: 1.5rem;
            background: linear-gradient(135deg, rgba(94, 15, 15, 0.9), rgba(74, 12, 12, 0.9)), 
                        url('https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: white;
        }
        .promo-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--gold);
        }
        .promo-text {
            margin-bottom: 1.5rem;
            opacity: 0.9;
        }
        .promo-btn {
            display: inline-block;
            background: var(--gold);
            color: var(--burgundy);
            border: none;
            padding: 0.6rem 1.8rem;
            font-size: 0.9rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 30px;
            transition: var(--transition);
            text-decoration: none;
        }
        .promo-btn:hover {
            background: var(--light-gold);
            color: var(--burgundy);
        }
        .quick-links {
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(94, 15, 15, 0.08);
            padding: 1.5rem;
        }
        .quick-links-title {
            font-family: 'Playfair Display', serif;
            color: var(--burgundy);
            font-size: 1.3rem;
            margin-bottom: 1rem;
        }
        .quick-link-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(200, 169, 126, 0.2);
        }
        .quick-link-item:last-child {
            border-bottom: none;
        }
        .quick-link-icon {
            width: 36px;
            height: 36px;
            background: rgba(94, 15, 15, 0.05);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: var(--burgundy);
        }
        .quick-link-text {
            flex: 1;
        }
        .quick-link-text a {
            color: var(--dark-text);
            text-decoration: none;
            transition: var(--transition);
        }
        .quick-link-text a:hover {
            color: var(--burgundy);
        }
        .quick-link-arrow {
            color: var(--gold);
        }
        footer {
            background: linear-gradient(135deg, var(--burgundy), var(--dark-burgundy));
            color: var(--light-text);
            text-align: center;
            padding: 3rem 1rem 2rem 1rem;
            margin-top: auto;
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
                    <div class="brand-subtitle">Retailer Dashboard</div>
                </div>
            </div>
            <div class="user-nav">
                <a href="/chat" class="d-flex align-items-center text-decoration-none me-3" style="color: var(--gold); font-weight: 500; transition: var(--transition);">
                    <i class="fas fa-comments me-1"></i> Chat
                </a>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="color: var(--gold);">
                        <i class="fas fa-bell me-1"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                            3
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown" style="min-width: 300px;">
                        <li><h6 class="dropdown-header">New Notifications (3)</h6></li>
                        <li><a class="dropdown-item d-flex" href="#">
                            <div class="me-3 text-success"><i class="fas fa-check-circle"></i></div>
                            <div>
                                <div class="small text-muted">Order #1001 Confirmed</div>
                                <span class="small">Your order has been confirmed</span>
                            </div>
                        </a></li>
                        <li><a class="dropdown-item d-flex" href="#">
                            <div class="me-3 text-warning"><i class="fas fa-exclamation-triangle"></i></div>
                            <div>
                                <div class="small text-muted">Low Stock Alert</div>
                                <span class="small">3 products running low</span>
                            </div>
                        </a></li>
                        <li><a class="dropdown-item d-flex" href="#">
                            <div class="me-3 text-info"><i class="fas fa-bullhorn"></i></div>
                            <div>
                                <div class="small text-muted">New Promotion</div>
                                <span class="small">10% discount this week</span>
                            </div>
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-center" href="#">View all notifications</a></li>
                    </ul>
                </div>
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Retailer') }}&background=5e0f0f&color=c8a97e&size=128" 
                     alt="User Avatar" class="user-avatar">
                <span class="user-name">{{ Auth::user()->name ?? 'Retailer Name' }}</span>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1>Retailer Portal</h1>
        <div class="subtitle">Your business at a glance with Terravin Wines</div>
        <div class="divider"></div>
    </div>

    <!-- Welcome Section -->
    <section class="welcome-section">
        <div class="welcome-card">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Retailer') }}&background=5e0f0f&color=c8a97e&size=128" 
                 alt="Retailer Avatar" class="welcome-avatar">
            <h2 class="welcome-title">Welcome, {{ Auth::user()->name ?? 'Retailer' }}</h2>
            <p class="welcome-text">Thank you for being a valued retailer. Here's an overview of your recent activity and quick access to important tools.</p>
            <div class="stats-container">
                <div class="stat-item">
                    <div class="stat-number">3</div>
                    <div class="stat-label">Pending Orders</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">5</div>
                    <div class="stat-label">Shipped</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">12</div>
                    <div class="stat-label">Delivered</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">UGX 8,450,000</div>
                    <div class="stat-label">Monthly Revenue</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Dashboard Actions -->
    <section class="dashboard-actions">
        <h2 class="section-title">Quick Actions</h2>
        <div class="action-grid">
            <div class="action-card">
                <div class="action-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h3>My Orders</h3>
                <p>View and manage your orders, track status, and reorder products. Create new purchase orders and check delivery schedules.</p>
                <a href="#" class="action-btn">View Orders</a>
            </div>
            <div class="action-card">
                <div class="action-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <h3>Browse Products</h3>
                <p>Explore our premium wine selection, check availability, and add products to your inventory with special trade pricing.</p>
                <a href="#" class="action-btn">Browse</a>
            </div>
            <div class="action-card">
                <div class="action-icon">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <h3>Invoices</h3>
                <p>Access your invoices, payment history, download receipts, and manage your account statements in one place.</p>
                <a href="#" class="action-btn">View Invoices</a>
            </div>
            <div class="action-card">
                <div class="action-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Sales Reports</h3>
                <p>Generate detailed sales reports, analyze performance metrics, and download data for your business planning.</p>
                <a href="#" class="action-btn">View Reports</a>
            </div>
        </div>
    </section>

    <!-- Main Dashboard Content -->
    <section class="dashboard-content">
        <div class="main-content">
            <!-- Sales Chart -->
            <div class="chart-card">
                <h2 class="section-title" style="text-align: left; margin-bottom: 1.5rem;">Monthly Sales Performance</h2>
                <div class="chart-container">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
            
            <!-- Recent Orders -->
            <div class="chart-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="section-title" style="text-align: left; margin: 0;">Recent Orders</h2>
                    <a href="#" class="view-all">View All Orders</a>
                </div>
                <div class="table-responsive">
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#1005</td>
                                <td>Jul 5, 2025</td>
                                <td>3</td>
                                <td>UGX 1,250,000</td>
                                <td><span class="status-badge status-pending">Pending</span></td>
                                <td><a href="#" class="text-primary">View</a></td>
                            </tr>
                            <tr>
                                <td>#1004</td>
                                <td>Jul 3, 2025</td>
                                <td>5</td>
                                <td>UGX 2,100,000</td>
                                <td><span class="status-badge status-processing">Processing</span></td>
                                <td><a href="#" class="text-primary">View</a></td>
                            </tr>
                            <tr>
                                <td>#1003</td>
                                <td>Jun 28, 2025</td>
                                <td>8</td>
                                <td>UGX 3,450,000</td>
                                <td><span class="status-badge status-shipped">Shipped</span></td>
                                <td><a href="#" class="text-primary">Track</a></td>
                            </tr>
                            <tr>
                                <td>#1002</td>
                                <td>Jun 22, 2025</td>
                                <td>4</td>
                                <td>UGX 1,750,000</td>
                                <td><span class="status-badge status-delivered">Delivered</span></td>
                                <td><a href="#" class="text-primary">Invoice</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Notifications -->
            <div class="notification-card">
                <div class="notification-header">
                    <h2 class="section-title" style="text-align: left; margin: 0; font-size: 1.5rem;">Notifications</h2>
                    <div class="view-all">
                        <a href="#">View All</a>
                    </div>
                </div>
                <div class="notification-item">
                    <div class="notification-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-title">Order #1001 Confirmed</div>
                        <p>Your order has been confirmed and is being processed.</p>
                        <div class="notification-time">2 hours ago</div>
                    </div>
                </div>
                <div class="notification-item">
                    <div class="notification-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-title">Order #1000 Shipped</div>
                        <p>Your order #1000 has been shipped and is on its way.</p>
                        <div class="notification-time">1 day ago</div>
                    </div>
                </div>
                <div class="notification-item">
                    <div class="notification-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-title">Low Stock Alert</div>
                        <p>3 of your products are running low on inventory.</p>
                        <div class="notification-time">3 days ago</div>
                    </div>
                </div>
            </div>
            
            <!-- Current Promotion -->
            <div class="promo-card">
                <h3 class="promo-title">Summer Special!</h3>
                <p class="promo-text">Enjoy 10% discount on all orders placed this week. Limited time offer for our valued retailers.</p>
                <a href="#" class="promo-btn">Shop Now</a>
            </div>
            
            <!-- Quick Links -->
            <div class="quick-links">
                <h3 class="quick-links-title">Quick Links</h3>
                <div class="quick-link-item">
                    <div class="quick-link-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="quick-link-text">
                        <a href="#">Product Catalog</a>
                    </div>
                    <div class="quick-link-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
                <div class="quick-link-item">
                    <div class="quick-link-icon">
                        <i class="fas fa-percentage"></i>
                    </div>
                    <div class="quick-link-text">
                        <a href="#">Current Promotions</a>
                    </div>
                    <div class="quick-link-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
                <div class="quick-link-item">
                    <div class="quick-link-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="quick-link-text">
                        <a href="#">Order History</a>
                    </div>
                    <div class="quick-link-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
                <div class="quick-link-item">
                    <div class="quick-link-icon">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <div class="quick-link-text">
                        <a href="#">Help Center</a>
                    </div>
                    <div class="quick-link-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
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
            +256 41 423 5678 • retailers@terravin.ug
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
    
    <script>
        // Sales Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Monthly Sales (UGX)',
                    data: [4500000, 5200000, 6100000, 5800000, 7200000, 8450000, 6200000],
                    backgroundColor: 'rgba(94, 15, 15, 0.7)',
                    borderColor: 'rgba(94, 15, 15, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'UGX ' + value.toLocaleString();
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'UGX ' + context.raw.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Notification dropdown
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
            const dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl)
            });
        });
    </script>
</body>
</html>