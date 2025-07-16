<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help & Support | TERRAVIN</title>
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
        .dashboard {
            width: 100vw;
            min-height: 100vh;
            display: block;
            margin-top: 70px;
        }
        .main-content {
            padding: 2.5rem 0;
            background-color: var(--light-gray);
            min-height: 80vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }
        .help-container {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            padding: 2rem 2.5rem 2.5rem 2.5rem;
        }
        .help-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--burgundy);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .help-desc {
            color: #666;
            margin-bottom: 2rem;
        }
        .help-search {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }
        .help-search input {
            flex: 1;
            padding: 0.8rem 1rem 0.8rem 2.5rem;
            border: 1px solid var(--gray);
            border-radius: var(--border-radius);
            font-family: inherit;
            background-color: #f9f5ed;
            font-size: 1rem;
            transition: var(--transition);
        }
        .help-search i {
            position: absolute;
            left: 1.5rem;
            color: var(--burgundy);
            font-size: 1rem;
        }
        .faq-section {
            margin-bottom: 2.5rem;
        }
        .faq-title {
            font-size: 1.2rem;
            color: var(--burgundy);
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .faq-list {
            list-style: none;
            padding: 0;
        }
        .faq-list li {
            background: var(--light-cream);
            border-radius: var(--border-radius);
            margin-bottom: 1rem;
            padding: 1rem 1.5rem;
            box-shadow: var(--shadow-sm);
        }
        .faq-question {
            font-weight: 600;
            color: var(--burgundy);
            margin-bottom: 0.5rem;
        }
        .faq-answer {
            color: #444;
        }
        .quick-nav {
            display: flex;
            gap: 2rem;
            margin-bottom: 2.5rem;
            justify-content: center;
        }
        .quick-nav a {
            color: var(--burgundy);
            font-weight: 500;
            text-decoration: none;
            background: var(--light-cream);
            padding: 0.7rem 1.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            transition: background 0.2s, color 0.2s;
        }
        .quick-nav a:hover {
            background: var(--gold);
            color: var(--burgundy);
        }
        .contact-support {
            background: var(--light-cream);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            margin-top: 2rem;
        }
        .contact-title {
            font-size: 1.1rem;
            color: var(--burgundy);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .contact-desc {
            color: #444;
            margin-bottom: 1rem;
        }
        .contact-email {
            color: var(--burgundy);
            font-weight: 600;
            text-decoration: none;
        }
        @media (max-width: 768px) {
            .main-content {
                padding: 1.2rem 0.5rem;
            }
            .help-container {
                padding: 1.2rem 0.7rem 1.5rem 0.7rem;
            }
            .quick-nav {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Wine-themed top nav bar for customer (copied from dashboard) -->
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
                            <li><a href="{{ route('help.index') }}" class="nav-link active"><i class="fas fa-question-circle"></i> Help</a></li>
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
        <main class="main-content">
            <div class="help-container">
                <div class="help-title"><i class="fas fa-question-circle"></i> Help & Support Center</div>
                <div class="help-desc">Find answers to common questions and learn how to use Terravin effectively.</div>
                <!-- Search Bar -->
                <div class="help-search position-relative mb-4">
                    <i class="fas fa-search position-absolute" style="left: 18px; top: 50%; transform: translateY(-50%);"></i>
                    <input type="text" class="form-control ps-5" placeholder="Search help topics...">
                </div>
                <!-- Quick Navigation -->
                <div class="quick-nav mb-4">
                    <a href="#getting-started"><i class="fas fa-rocket"></i> Getting Started</a>
                    <a href="#orders"><i class="fas fa-shopping-cart"></i> Orders</a>
                    <a href="#profile"><i class="fas fa-user"></i> Profile Management</a>
                    <a href="#contact"><i class="fas fa-headset"></i> Contact Support</a>
                </div>
                <!-- FAQ Section -->
                <div class="faq-section" id="getting-started">
                    <div class="faq-title"><i class="fas fa-rocket"></i> Getting Started</div>
                    <ul class="faq-list">
                        <li>
                            <div class="faq-question">How do I create an account?</div>
                            <div class="faq-answer">Click on the Sign Up button on the login page and fill in your details to create a new account.</div>
                        </li>
                        <li>
                            <div class="faq-question">How do I log in?</div>
                            <div class="faq-answer">Enter your email and password on the login page and click Login. If you forgot your password, use the 'Forgot Password' link.</div>
                        </li>
                        <li>
                            <div class="faq-question">What are the different user roles?</div>
                            <div class="faq-answer">Terravin supports roles such as Customer, Vendor, Wholesaler, and Admin, each with different permissions and access.</div>
                        </li>
                                    </ul>
                </div>
                <div class="faq-section" id="orders">
                    <div class="faq-title"><i class="fas fa-shopping-cart"></i> Orders</div>
                    <ul class="faq-list">
                        <li>
                            <div class="faq-question">How do I place an order?</div>
                            <div class="faq-answer">Browse the Wine Shop, add items to your cart, and proceed to checkout to place your order.</div>
                        </li>
                        <li>
                            <div class="faq-question">How can I track my order?</div>
                            <div class="faq-answer">Go to the Orders page to view the status and details of your orders.</div>
                        </li>
                        <li>
                            <div class="faq-question">Can I cancel or modify my order?</div>
                            <div class="faq-answer">Contact support as soon as possible if you need to cancel or modify an order.</div>
                        </li>
                    </ul>
                </div>
                <div class="faq-section" id="profile">
                    <div class="faq-title"><i class="fas fa-user"></i> Profile Management</div>
                    <ul class="faq-list">
                        <li>
                            <div class="faq-question">How do I update my profile photo?</div>
                            <div class="faq-answer">Go to your profile page and click on the photo to upload a new one.</div>
                        </li>
                        <li>
                            <div class="faq-question">How do I change my password?</div>
                            <div class="faq-answer">Visit the profile page and use the 'Change Password' option to update your password.</div>
                        </li>
                    </ul>
                </div>
                <!-- Contact Support -->
                <div class="contact-support" id="contact">
                    <div class="contact-title"><i class="fas fa-headset"></i> Contact Support</div>
                    <div class="contact-desc">Need additional help? Contact our support team:</div>
                    <div><a href="mailto:support@terravin.com" class="contact-email"><i class="fas fa-envelope"></i> support@terravin.com</a></div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 