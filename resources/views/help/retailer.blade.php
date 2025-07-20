<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retailer Help | TERRAVIN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --burgundy: #5e0f0f;
            --gold: #c8a97e;
            --cream: #f5f0e6;
            --light-cream: #f9f5ed;
            --dark-text: #2a2a2a;
            --border-radius: 12px;
        }
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--light-cream);
            color: var(--dark-text);
        }
        .wine-top-bar {
            background: linear-gradient(135deg, var(--burgundy) 0%, #8b1a1a 100%);
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
        .nav-link:hover, .nav-link.active {
            color: var(--gold);
            background-color: rgba(200, 169, 126, 0.1);
            text-decoration: none;
        }
        .dashboard {
            width: 100vw;
            min-height: 100vh;
            display: block;
            margin-top: 70px;
        }
        .main-content {
            padding: 2rem 0;
            background-color: var(--light-cream);
            min-height: 80vh;
        }
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--burgundy);
            font-weight: 600;
        }
        .help-card {
            background: #fff;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 8px rgba(94, 15, 15, 0.08);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .faq-question {
            font-weight: 600;
            color: var(--burgundy);
            margin-top: 1.5rem;
        }
        .faq-answer {
            margin-bottom: 1.2rem;
        }
        .highlight {
            color: var(--gold);
            font-weight: 600;
        }
    </style>
</head>
<body>
    <!-- Wine-themed top nav bar for retailer -->
    <div class="wine-top-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <a class="wine-brand" href="{{ route('retailer.dashboard') }}">
                        <i class="fas fa-wine-bottle"></i>
                    </a>
                </div>
                <div class="col-md-7">
                    <nav class="wine-nav">
                        <ul class="nav-links">
                            <li><a href="{{ route('retailer.dashboard') }}" class="nav-link"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                            <li><a href="{{ route('orders.index') }}" class="nav-link"><i class="fas fa-shopping-bag"></i> Orders</a></li>
                            <li><a href="{{ route('inventory.index') }}" class="nav-link"><i class="fas fa-boxes"></i> Inventory</a></li>
                            <li><a href="{{ route('procurement.dashboard') }}" class="nav-link"><i class="fas fa-shopping-cart"></i> Procurement</a></li>
                            <li><a href="{{ route('help.retailer') }}" class="nav-link active"><i class="fas fa-question-circle"></i> Help</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="dashboard">
        <main class="main-content container">
            <div class="section-header">
                <h2 class="section-title"><i class="fas fa-question-circle me-2"></i> Retailer Help Center</h2>
            </div>
            <div class="help-card">
                <h4 class="text-burgundy mb-3">Welcome, Retailer!</h4>
                <p>Here you'll find answers and guidance tailored for retailers using the Terravin platform. For additional support, contact our <span class="highlight">Retailer Success Team</span>.</p>
            </div>
            <div class="help-card">
                <h5 class="faq-question"><i class="fas fa-boxes me-2"></i> How do I manage my inventory?</h5>
                <div class="faq-answer">Go to <span class="highlight">Inventory</span> from the navigation bar. Here you can add, edit, or remove wine items, update stock levels, and view low-stock alerts.</div>
                <h5 class="faq-question"><i class="fas fa-shopping-cart me-2"></i> How do I create a procurement request?</h5>
                <div class="faq-answer">Navigate to <span class="highlight">Procurement</span> and click <b>New Procurement</b>. Fill in the required details and submit your request for approval.</div>
                <h5 class="faq-question"><i class="fas fa-shopping-bag me-2"></i> How do I track my orders?</h5>
                <div class="faq-answer">Visit <span class="highlight">Orders</span> to see all your orders, their statuses, and shipment tracking information.</div>
                <h5 class="faq-question"><i class="fas fa-user-cog me-2"></i> How do I update my profile or settings?</h5>
                <div class="faq-answer">Click your profile icon in the top right, then select <b>Profile</b> to update your information or change your password.</div>
                <h5 class="faq-question"><i class="fas fa-headset me-2"></i> Who do I contact for support?</h5>
                <div class="faq-answer">Email <a href="mailto:support@terravin.com" class="highlight">support@terravin.com</a> or use the in-app chat for real-time assistance.</div>
            </div>
            <div class="help-card">
                <h5 class="faq-question"><i class="fas fa-lightbulb me-2"></i> Tips for Retailers</h5>
                <ul>
                    <li>Use the <span class="highlight">Low Stock</span> alerts to reorder popular wines before they run out.</li>
                    <li>Check the <span class="highlight">Procurement</span> dashboard for pending approvals and deliveries.</li>
                    <li>Customize your notifications in your <b>Profile</b> settings.</li>
                    <li>Download reports from the <span class="highlight">Inventory</span> or <span class="highlight">Orders</span> pages for your records.</li>
                </ul>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 