<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart | Terravin Wines</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Marcellus&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --maroon: #5e0f0f;
            --maroon-dark: #4a0c0c;
            --maroon-light: #8b1a1a;
            --gold: #c8a97e;
            --gold-dark: #b8996e;
            --gold-light: #e5d4b4;
            --cream: #f8f4eb;
            --ivory: #fffaf0;
        }
        
        body {
            font-family: 'Marcellus', serif;
            background-color: var(--cream);
            color: #333;
            padding-top: 80px; /* Account for fixed navbar */
        }
        
        /* Navigation Bar - Maroon Theme */
        .navbar {
            background-color: var(--maroon) !important;
            padding: 0.8rem 0;
            box-shadow: 0 2px 15px rgba(0,0,0,0.2);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        
        .navbar-brand {
            font-family: 'Cinzel', serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--gold-light) !important;
            letter-spacing: 1px;
            margin-right: 2rem;
        }
        
        .nav-link {
            font-family: 'Marcellus', serif;
            color: var(--gold-light) !important;
            margin: 0 1rem;
            position: relative;
            padding: 0.5rem 0;
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
        
        .nav-link:hover:after,
        .nav-link.active:after {
            width: 100%;
        }
        
        /* Cart Widget Styles */
        .cart-widget {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .cart-item {
            display: flex;
            align-items: center;
            padding: 1.5rem 0;
            border-bottom: 1px solid rgba(200, 169, 126, 0.2);
        }
        
        .cart-item:last-child {
            border-bottom: none;
        }
        
        .cart-item-img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            background: var(--ivory);
            padding: 10px;
            border-radius: 8px;
            border: 1px solid rgba(200, 169, 126, 0.3);
            margin-right: 1.5rem;
        }
        
        .cart-item-details {
            flex: 1;
        }
        
        .cart-item-name {
            font-family: 'Cinzel', serif;
            color: var(--maroon);
            margin-bottom: 0.5rem;
        }
        
        .cart-item-price {
            color: var(--maroon);
            font-weight: 500;
        }
        
        .quantity-control {
            display: flex;
            align-items: center;
            margin: 0.5rem 0;
        }
        
        .quantity-btn {
            width: 32px;
            height: 32px;
            background: var(--gold-light);
            border: none;
            color: var(--maroon);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .quantity-btn:hover {
            background: var(--gold);
        }
        
        .quantity-input {
            width: 50px;
            text-align: center;
            margin: 0 8px;
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 4px;
        }
        
        .remove-btn {
            background: transparent;
            border: none;
            color: #dc3545;
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }
        
        .remove-btn:hover {
            transform: scale(1.1);
        }
        
        /* Order Summary Widget */
        .summary-widget {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 5px 25px rgba(0,0,0,0.1);
            border-top: 3px solid var(--gold);
            position: sticky;
            top: 100px;
        }
        
        .summary-title {
            font-family: 'Cinzel', serif;
            color: var(--maroon);
            border-bottom: 1px dashed var(--gold);
            padding-bottom: 0.75rem;
            margin-bottom: 1.5rem;
            font-size: 1.3rem;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
        
        .total-row {
            font-weight: 600;
            font-size: 1.2rem;
            color: var(--maroon);
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px dashed var(--gold);
        }
        
        /* Empty Cart State */
        .empty-cart-widget {
            background: white;
            border-radius: 10px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 5px 25px rgba(0,0,0,0.1);
        }
        
        .empty-cart-icon {
            font-size: 4rem;
            color: var(--gold);
            margin-bottom: 1.5rem;
        }
        
        .empty-cart-title {
            font-family: 'Cinzel', serif;
            color: var(--maroon);
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }
        
        /* Footer */
        .footer {
            background: var(--maroon);
            color: white;
            padding: 3rem 0;
            margin-top: 4rem;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .cart-item {
                flex-direction: column;
                text-align: center;
            }
            
            .cart-item-img {
                margin-right: 0;
                margin-bottom: 1rem;
            }
            
            .quantity-control {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Maroon Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('orders.catalog') }}">TERRAVIN</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.catalog') }}">Browse Wines</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Our Vineyards</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About Us</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <a href="#" class="btn btn-outline-light me-2">
                        <i class="fas fa-user"></i>
                    </a>
                    <a href="{{ route('cart.view') }}" class="btn btn-gold position-relative">
                        <i class="fas fa-shopping-cart"></i>
                        @php
                            $cart = session('cart', []);
                            $cartCount = array_sum(array_column($cart, 'quantity'));
                        @endphp
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge bg-light text-maroon rounded-pill">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <h1 class="text-center mb-4" style="font-family: 'Cinzel', serif; color: var(--maroon);">Your Wine Cart</h1>
        
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
        
        @if(count($products) > 0)
        <div class="row">
            <div class="col-lg-8">
                <div class="cart-widget">
                    <h2 class="mb-4" style="font-family: 'Cinzel', serif; color: var(--maroon);">Your Selections</h2>
                    
                    @foreach($products as $product)
                    <div class="cart-item">
                        <img src="{{ $product->image_url ?? 'https://images.unsplash.com/photo-1568219656418-15c329312bf1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=300&q=80' }}" 
                             class="cart-item-img" 
                             alt="{{ $product->name }}">
                        
                        <div class="cart-item-details">
                            <h4 class="cart-item-name">{{ $product->name }}</h4>
                            <div class="cart-item-price">UGX {{ number_format($product->price, 0, '.', ',') }}</div>
                            
                            <div class="quantity-control">
                                <form action="{{ route('cart.decrease', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="quantity-btn">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </form>
                                <span class="quantity-input">{{ $product->cart_quantity }}</span>
                                <form action="{{ route('cart.increase', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="quantity-btn">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <div class="text-end">
                            <div class="mb-2" style="font-weight: 500; color: var(--maroon);">
                                UGX {{ number_format($product->cart_subtotal, 0, '.', ',') }}
                            </div>
                            <form action="{{ route('cart.remove', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="remove-btn">
                                    <i class="fas fa-trash"></i> Remove
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="d-flex justify-content-between mt-4 pt-3">
                        <a href="{{ route('orders.catalog') }}" class="btn btn-outline-maroon">
                            <i class="fas fa-chevron-left me-2"></i> Continue Shopping
                        </a>
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-trash-alt me-2"></i> Clear Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="summary-widget">
                    <h3 class="summary-title">Order Summary</h3>
                    
                    <div class="summary-row">
                        <span>Subtotal ({{ count($products) }} items)</span>
                        <span class="text-maroon">UGX {{ number_format($total, 0, '.', ',') }}</span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span class="text-maroon">UGX 10,000</span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Tax (18%)</span>
                        <span class="text-maroon">UGX {{ number_format($total * 0.18, 0, '.', ',') }}</span>
                    </div>
                    
                    <div class="summary-row total-row">
                        <span>Total</span>
                        <span class="text-maroon">UGX {{ number_format($total + 10000 + ($total * 0.18), 0, '.', ',') }}</span>
                    </div>
                    
                    <a href="{{ route('cart.checkout') }}" class="btn btn-maroon w-100 py-2 mt-3">
                        <i class="fas fa-credit-card me-2"></i> Proceed to Checkout
                    </a>
                    
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            <i class="fas fa-lock me-1"></i> Secure SSL encryption
                        </small>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="empty-cart-widget">
            <div class="empty-cart-icon">
                <i class="fas fa-wine-glass-alt"></i>
            </div>
            <h3 class="empty-cart-title">Your Cart is Empty</h3>
            <p class="mb-4">Discover our exceptional wine selection</p>
            <a href="{{ route('orders.catalog') }}" class="btn btn-maroon">
                <i class="fas fa-wine-bottle me-2"></i> Browse Wines
            </a>
        </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-4 mb-md-0">
                    <h5 style="font-family: 'Cinzel', serif; color: var(--gold-light);">Terravin Wines</h5>
                    <p class="text-gold-light">Premium wines crafted with passion and tradition in the heart of wine country.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-gold-light me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-gold-light me-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gold-light me-3"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            <div class="text-center mt-4 pt-3" style="border-top: 1px solid rgba(200, 169, 126, 0.2);">
                <p class="small text-gold-light">&copy; 2023 Terravin Wines. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>