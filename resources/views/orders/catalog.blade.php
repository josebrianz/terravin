<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terravin Wines | Premium Wine Selection</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&family=Raleway:wght@300;400;500&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --maroon: #5e0f0f;
            --maroon-light: #7a1a1a;
            --gold: #c8a97e;
            --gold-light: #e5d4b4;
            --cream: #f9f7f2;
            --dark: #2a2a2a;
        }
        
        body { 
            font-family: 'Raleway', sans-serif;
            background-color: var(--cream);
            color: var(--dark);
            line-height: 1.6;
        }
        
        .text-maroon { color: var(--maroon) !important; }
        .bg-maroon { 
            background-color: var(--maroon) !important;
            color: white;
        }
        .text-gold { color: var(--gold) !important; }
        .bg-gold { background-color: var(--gold) !important; }
        
        .btn-terravin { 
            background-color: var(--maroon); 
            color: white;
            border: none;
            font-family: 'Playfair Display', serif;
            letter-spacing: 0.5px;
            padding: 8px 20px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-terravin:hover { 
            background-color: var(--maroon-light); 
            color: white;
            transform: translateY(-2px);
        }
        
        .btn-terravin:after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }
        
        .btn-terravin:hover:after {
            left: 100%;
        }
        
        .card { 
            border-radius: 0; 
            transition: all 0.3s ease;
            border: none;
            background: white;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .card-img-container {
            height: 280px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
            position: relative;
            overflow: hidden;
        }
        
        .card-img-top {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
            transition: transform 0.5s ease;
        }
        
        .card:hover .card-img-top {
            transform: scale(1.05);
        }
        
        .card-body {
            padding: 1.5rem;
            border-top: 1px solid var(--gold-light);
        }
        
        .card-title { 
            font-family: 'Playfair Display', serif;
            font-weight: 700; 
            font-size: 1.2rem;
            color: var(--maroon);
            margin-bottom: 0.5rem;
        }
        
        .card-subtitle {
            font-family: 'Raleway', sans-serif;
            font-weight: 500;
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .category-title { 
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 2rem;
            color: var(--maroon);
            margin-bottom: 2rem;
            position: relative;
            display: inline-block;
        }
        
        .category-title:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--gold);
        }
        
        .price {
            font-weight: 600;
            color: var(--maroon);
            font-size: 1.1rem;
            margin: 0.5rem 0;
        }
        
        .availability {
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }
        
        .in-stock {
            color: #2a8a5a;
        }
        
        .low-stock {
            color: var(--gold);
        }
        
        .out-of-stock {
            color: #b71c1c;
        }
        
        .wine-details {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 1rem;
            padding-top: 0.75rem;
            border-top: 1px dashed #ddd;
        }
        
        .wine-details strong {
            color: var(--dark);
        }
        
        .quantity-input {
            width: 60px;
            text-align: center;
            border: 1px solid #ddd;
            padding: 5px;
        }
        
        .navbar {
            padding: 1rem 0;
            background: white !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--maroon) !important;
        }
        
        .nav-link {
            font-family: 'Raleway', sans-serif;
            font-weight: 500;
            color: var(--dark) !important;
            margin: 0 10px;
            position: relative;
        }
        
        .nav-link:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gold);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover:after {
            width: 100%;
        }
        
        .nav-link.active {
            color: var(--maroon) !important;
        }
        
        .hero-section {
            background: var(--maroon);
            color: white;
            padding: 4rem 0;
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect width="50" height="50" x="0" y="0" fill="%235e0f0f" opacity="0.8"></rect><rect width="50" height="50" x="50" y="50" fill="%235e0f0f" opacity="0.8"></rect></svg>');
            background-size: 20px 20px;
            opacity: 0.1;
        }
        
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 3rem;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }
        
        .hero-title:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--gold);
        }
        
        .hero-subtitle {
            font-family: 'Raleway', sans-serif;
            font-weight: 400;
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 2rem;
            opacity: 0.9;
        }
        
        .filter-section {
            background: white;
            padding: 1.5rem;
            margin-bottom: 3rem;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        }
        
        .footer {
            background: var(--maroon);
            color: white;
            padding: 4rem 0 2rem;
            margin-top: 5rem;
        }
        
        .footer-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }
        
        .footer-title:after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 40px;
            height: 2px;
            background: var(--gold);
        }
        
        .footer-links a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .footer-links a:hover {
            color: white;
            padding-left: 5px;
        }
        
        .social-icons a {
            color: white;
            background: rgba(255,255,255,0.1);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background: var(--gold);
            color: var(--maroon);
            transform: translateY(-3px);
        }
        
        .copyright {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 2rem;
            margin-top: 3rem;
            font-size: 0.9rem;
            color: rgba(255,255,255,0.6);
        }
        
        .badge-new {
            background: var(--gold);
            color: var(--maroon);
            font-family: 'Raleway', sans-serif;
            font-weight: 600;
            letter-spacing: 1px;
            padding: 5px 10px;
            border-radius: 0;
            position: absolute;
            top: 15px;
            left: 0;
        }
        
        .badge-best {
            background: var(--maroon);
            color: white;
            font-family: 'Raleway', sans-serif;
            font-weight: 600;
            letter-spacing: 1px;
            padding: 5px 10px;
            border-radius: 0;
            position: absolute;
            top: 15px;
            right: 0;
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .category-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <span class="text-maroon">TERRAVIN</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Wines</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Vineyards</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Our Story</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
                <div class="ms-3 d-flex align-items-center">
                    <a href="#" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-user"></i>
                    </a>
                    <a href="{{ route('cart.view') }}" class="btn btn-terravin position-relative">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge bg-gold text-maroon rounded-pill">
                            3
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <h1 class="hero-title">Terravin Wines</h1>
            <p class="hero-subtitle">Crafted with precision, aged to perfection. Experience the essence of our vineyards in every bottle.</p>
            <a href="#wines" class="btn btn-terravin mt-3">
                Explore Our Collection <i class="fas fa-arrow-down ms-2"></i>
            </a>
        </div>
    </div>

    <div class="container py-4" id="wines">
        <!-- Search and Filter Section -->
        <div class="filter-section">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search Terravin wines...">
                        <button class="btn btn-terravin" type="button">
                            <i class="fas fa-search me-1"></i> Search
                        </button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-md-end">
                        <div class="dropdown me-2">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                            <ul class="dropdown-menu">
                                <li><h6 class="dropdown-header">By Price</h6></li>
                                <li><a class="dropdown-item" href="#">Under UGX 50,000</a></li>
                                <li><a class="dropdown-item" href="#">UGX 50,000 - 100,000</a></li>
                                <li><a class="dropdown-item" href="#">Over UGX 100,000</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><h6 class="dropdown-header">By Type</h6></li>
                                <li><a class="dropdown-item" href="#">Red Wines</a></li>
                                <li><a class="dropdown-item" href="#">White Wines</a></li>
                                <li><a class="dropdown-item" href="#">Rosé</a></li>
                                <li><a class="dropdown-item" href="#">Sparkling</a></li>
                            </ul>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown">
                                <i class="fas fa-sort me-1"></i> Sort By
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Featured</a></li>
                                <li><a class="dropdown-item" href="#">Price: Low to High</a></li>
                                <li><a class="dropdown-item" href="#">Price: High to Low</a></li>
                                <li><a class="dropdown-item" href="#">A-Z</a></li>
                                <li><a class="dropdown-item" href="#">Newest</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Messages/Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <!-- Product Catalog -->
        <div class="row g-4">
            @foreach($categories as $category => $wines)
                <div class="col-12">
                    <h2 class="category-title">{{ $category }}</h2>
                </div>
                @foreach($wines as $wine)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card h-100">
                        <!-- Product Image -->
                        <div class="card-img-container">
                            @if($wine->is_new)
                            <span class="badge-new">NEW</span>
                            @endif
                            @if($wine->is_best_seller)
                            <span class="badge-best">BEST SELLER</span>
                            @endif
                            @php
                                $img = match($wine->category) {
                                    'Red Wine' => 'https://source.unsplash.com/400x300/?red-wine,glass',
                                    'White Wine' => 'https://source.unsplash.com/400x300/?white-wine,glass',
                                    'Sparkling Wine' => 'https://source.unsplash.com/400x300/?champagne,glass',
                                    'Rosé Wine' => 'https://source.unsplash.com/400x300/?rose-wine,glass',
                                    'Dessert Wine' => 'https://source.unsplash.com/400x300/?dessert-wine,glass',
                                    default => 'https://source.unsplash.com/400x300/?wine,glass',
                                };
                            @endphp
                            <img src="{{ $img }}" alt="{{ $wine->name }}" class="card-img-top wine-img">
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <!-- Wine Name and Subtitle -->
                            <h5 class="card-title">{{ $wine->name }}</h5>
                            <h6 class="card-subtitle">{{ $wine->subtitle ?? 'Premium Selection' }}</h6>
                            
                            <!-- Wine Details -->
                            <div class="wine-details">
                                <div class="mb-1"><strong>Vintage:</strong> {{ $wine->vintage ?? 'NV' }}</div>
                                <div class="mb-1"><strong>Varietal:</strong> {{ $wine->varietal ?? 'Blend' }}</div>
                                <div><strong>Region:</strong> {{ $wine->region ?? 'Terravin Vineyards' }}</div>
                            </div>
                            
                            <!-- Price -->
                            <div class="price">UGX {{ number_format($wine->unit_price, 0, '.', ',') }}</div>
                            
                            <!-- Availability -->
                            @php
                                $availabilityClass = 'in-stock';
                                if($wine->quantity == 0) {
                                    $availabilityClass = 'out-of-stock';
                                } elseif($wine->quantity < 5) {
                                    $availabilityClass = 'low-stock';
                                }
                            @endphp
                            <div class="availability {{ $availabilityClass }}">
                                <i class="fas fa-{{ $wine->quantity == 0 ? 'times-circle' : ($wine->quantity < 5 ? 'exclamation-circle' : 'check-circle') }} me-1"></i>
                                @if($wine->quantity == 0)
                                    Out of Stock
                                @elseif($wine->quantity < 5)
                                    Only {{ $wine->quantity }} left!
                                @else
                                    In Stock
                                @endif
                            </div>
                            
                            <!-- Add to Cart Form -->
                            <form action="{{ route('cart.add', $wine->id) }}" method="POST" class="mt-auto pt-3">
                                @csrf
                                <div class="d-flex align-items-center">
                                    <input type="number" name="quantity" class="form-control quantity-input me-2" min="1" max="{{ $wine->quantity }}" value="1" required {{ $wine->quantity == 0 ? 'disabled' : '' }}>
                                    <button class="btn btn-terravin flex-grow-1" type="submit" {{ $wine->quantity == 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-cart-plus me-1"></i> {{ $wine->quantity == 0 ? 'Sold Out' : 'Add to Cart' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            @endforeach
        </div>
        
        <!-- Pagination -->
        <nav aria-label="Wine pagination" class="mt-5">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
                <li class="page-item active">
                    <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">3</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="footer-title">Terravin Wines</h5>
                    <p>Our passion for winemaking is reflected in every bottle we produce, from vine to table.</p>
                    <div class="social-icons mt-4">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
                <div class="col-md-2 mb-4 mb-md-0">
                    <h5 class="footer-title">Shop</h5>
                    <div class="footer-links">
                        <a href="#">All Wines</a>
                        <a href="#">New Arrivals</a>
                        <a href="#">Best Sellers</a>
                        <a href="#">Gift Packs</a>
                        <a href="#">Special Offers</a>
                    </div>
                </div>
                <div class="col-md-2 mb-4 mb-md-0">
                    <h5 class="footer-title">About</h5>
                    <div class="footer-links">
                        <a href="#">Our Story</a>
                        <a href="#">The Vineyards</a>
                        <a href="#">Winemaking</a>
                        <a href="#">Sustainability</a>
                        <a href="#">Awards</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <h5 class="footer-title">Contact Us</h5>
                    <div class="footer-links">
                        <a href="#"><i class="fas fa-map-marker-alt me-2"></i> Plot 42 Lakeside Drive • Entebbe, Uganda</a>
                        <a href="#"><i class="fas fa-phone me-2"></i> +256 700 123456</a>
                        <a href="#"><i class="fas fa-envelope me-2"></i> info@terravin.com</a>
                        <a href="#"><i class="fas fa-clock me-2"></i> Mon-Fri: 9AM-5PM</a>
                    </div>
                </div>
            </div>
            <div class="copyright text-center">
                <p>&copy; 2025 Terravin Wines. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Additional JavaScript for interactivity -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update quantity input max based on availability
            document.querySelectorAll('input[name="quantity"]').forEach(input => {
                input.addEventListener('change', function() {
                    const max = parseInt(this.max);
                    if (this.value > max) {
                        this.value = max;
                    }
                    if (this.value < 1) {
                        this.value = 1;
                    }
                });
            });
            
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
        });
    </script>
</body>
</html>