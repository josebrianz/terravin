<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Dashboard | Terravin Wines</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
                    <div class="brand-subtitle">Supplier Dashboard</div>
                </div>
            </div>
            <div class="user-nav">
                <a href="/chat" class="d-flex align-items-center text-decoration-none me-3" style="color: var(--gold); font-weight: 500; transition: var(--transition);">
                    <i class="fas fa-comments me-1"></i> Chat
                </a>
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Supplier') }}&background=5e0f0f&color=c8a97e&size=128" 
                     alt="User Avatar" class="user-avatar">
                <span class="user-name">{{ Auth::user()->name ?? 'Supplier Name' }}</span>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1>Supplier Portal</h1>
        <div class="subtitle">Manage your supply chain with Terravin Wines</div>
        <div class="divider"></div>
    </div>

    <!-- Welcome Section -->
    <section class="welcome-section">
        <div class="welcome-card">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Supplier') }}&background=5e0f0f&color=c8a97e&size=128" 
                 alt="Supplier Avatar" class="welcome-avatar">
            <h2 class="welcome-title">Welcome, {{ Auth::user()->name ?? 'Supplier' }}</h2>
            <p class="welcome-text">Thank you for being a valued supplier to Terravin Wines. Here's an overview of your recent activity and quick access to important tools.</p>
            
            <div class="stats-container">
                <div class="stat-item">
                    <div class="stat-number">24</div>
                    <div class="stat-label">Active Orders</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">On-Time Delivery</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">4.8</div>
                    <div class="stat-label">Avg. Rating</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">$42K</div>
                    <div class="stat-label">This Quarter</div>
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
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h3>Manage Orders</h3>
                <p>View and manage your current supply orders, track status, and update delivery information.</p>
                <a href="#" class="action-btn">View Orders</a>
            </div>
            <div class="action-card">
                <div class="action-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <h3>Delivery Schedule</h3>
                <p>Check upcoming delivery dates and manage your logistics for timely shipments.</p>
                <a href="#" class="action-btn">View Schedule</a>
            </div>
            <div class="action-card">
                <div class="action-icon">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <h3>Invoices & Payments</h3>
                <p>Access your invoices, payment history, and download receipts for your records.</p>
                <a href="#" class="action-btn">View Invoices</a>
            </div>
            <div class="action-card">
                <div class="action-icon">
                    <i class="fas fa-warehouse"></i>
                </div>
                <h3>Inventory Management</h3>
                <p>Update your available stock levels and manage product listings.</p>
                <a href="#" class="action-btn">Manage Inventory</a>
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
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">Order #TV-2023-045 Confirmed</div>
                    <p>Your supply order has been confirmed and scheduled for delivery on October 15, 2023.</p>
                    <div class="notification-time">2 hours ago</div>
                </div>
            </div>
            
            <div class="notification-item">
                <div class="notification-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">Inventory Update Required</div>
                    <p>Please update your stock levels for Pinot Noir grapes by October 10th.</p>
                    <div class="notification-time">1 day ago</div>
                </div>
            </div>
            
            <div class="notification-item">
                <div class="notification-icon">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">New Invoice Available</div>
                    <p>Invoice #INV-9876 for your August delivery is now available for download.</p>
                    <div class="notification-time">3 days ago</div>
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
            +256 41 423 5678 • suppliers@terravin.ug
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
</body>
</html>