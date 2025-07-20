<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart | TERRAVIN</title>
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
        .cart-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(200, 169, 126, 0.2);
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
        .btn-outline-burgundy {
            background: transparent;
            color: var(--burgundy);
            border: 2px solid var(--burgundy);
            border-radius: 2rem;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            transition: var(--transition);
        }
        .btn-outline-burgundy:hover {
            background: var(--burgundy);
            color: white;
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
                            <li><a href="{{ route('retailer.catalog') }}" class="nav-link"><i class="fas fa-store"></i> Product Catalog</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="d-flex align-items-center gap-4">
                    <div class="dropdown">
                        <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="profile-photo-placeholder-large rounded-circle d-flex align-items-center justify-content-center me-2" style="border: 6px solid var(--gold); background: linear-gradient(135deg, var(--burgundy) 0%, #8b1a1a 100%); width: 72px; height: 72px; color: #fff; font-size: 2rem;">
                                <span class="fw-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                            <span class="user-name">{{ Auth::user()->name }} <span class="text-gold" style="font-weight: 500;">(Retailer)</span></span>
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="page-title mb-0">My Cart</h1>
                <a href="{{ route('retailer.catalog') }}" class="btn btn-outline-burgundy">
                    <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                </a>
            </div>
            
            @if(count($cartItems) > 0)
                <div class="row">
                    <div class="col-lg-8">
                        <div class="cart-card p-4">
                            <h4 class="mb-4"><i class="fas fa-shopping-cart me-2"></i>Cart Items</h4>
                            @foreach($cartItems as $item)
                                <div class="d-flex align-items-center border-bottom pb-3 mb-3 cart-item-row" data-product-id="{{ $item['product']->id }}">
                                    <div class="flex-shrink-0 me-3">
                                        @if(!empty($item['product']->images) && is_array($item['product']->images) && count($item['product']->images) > 0)
                                            @php $imgPath = $item['product']->images[0]; @endphp
                                            @if(Str::startsWith($imgPath, 'inventory_images/'))
                                                <img src="{{ asset('storage/' . $imgPath) }}" alt="{{ $item['product']->name }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                                            @else
                                                <img src="{{ asset('wine_images/' . $imgPath) }}" alt="{{ $item['product']->name }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                                            @endif
                                        @else
                                            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--burgundy) 0%, var(--light-burgundy) 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--gold);">
                                                <i class="fas fa-wine-bottle"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1">{{ $item['product']->name }}</h5>
                                        <p class="text-muted mb-1">{{ $item['product']->description }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold text-burgundy">${{ number_format($item['product']->unit_price, 2) }}</span>
                                            <div class="input-group input-group-sm" style="width: 120px;">
                                                <button class="btn btn-outline-burgundy" type="button" onclick="updateQuantity({{ $item['product']->id }}, {{ $item['quantity'] - 1 }})" @if($item['quantity'] <= 1) disabled @endif>-</button>
                                                <input type="text" class="form-control text-center cart-qty-input" value="{{ $item['quantity'] }}" readonly style="background: var(--light-gray);" data-product-id="{{ $item['product']->id }}">
                                                <button class="btn btn-outline-burgundy" type="button" onclick="updateQuantity({{ $item['product']->id }}, {{ $item['quantity'] + 1 }})">+</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <h5 class="text-burgundy cart-item-subtotal" data-product-id="{{ $item['product']->id }}">${{ number_format($item['subtotal'], 2) }}</h5>
                                        <button class="btn btn-sm btn-outline-danger" onclick="removeFromCart({{ $item['product']->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="cart-card p-4">
                            <h4 class="mb-4"><i class="fas fa-receipt me-2"></i>Order Summary</h4>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Subtotal:</span>
                                <span class="fw-bold">${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Shipping:</span>
                                <span class="fw-bold">$0.00</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <span class="h5">Total:</span>
                                <span class="h5 text-burgundy">${{ number_format($total, 2) }}</span>
                            </div>
                            <button class="btn btn-burgundy w-100 mb-3" onclick="window.location.href='/retailer/checkout'">
                                <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
                            </button>
                            <button class="btn btn-outline-burgundy w-100" onclick="clearCart()">
                                <i class="fas fa-trash me-2"></i>Clear Cart
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                    <h3 class="text-muted">Your cart is empty</h3>
                    <p class="text-muted mb-4">Start shopping to add products to your cart</p>
                    <a href="{{ route('retailer.catalog') }}" class="btn btn-burgundy">
                        <i class="fas fa-store me-2"></i>Browse Products
                    </a>
                </div>
            @endif
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function removeFromCart(productId) {
            if (confirm('Remove this item from cart?')) {
                fetch('/retailer/cart/remove', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        wine_id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
            }
        }
        
        function clearCart() {
            if (confirm('Clear all items from cart?')) {
                fetch('/retailer/cart/clear', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
            }
        }

        function updateQuantity(productId, newQty) {
            if (newQty < 1) return;
            fetch('/retailer/cart/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    wine_id: productId,
                    quantity: newQty
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Option 1: Reload page for simplicity
                    location.reload();
                    // Option 2: Update DOM (uncomment below to update without reload)
                    /*
                    document.querySelector(`input.cart-qty-input[data-product-id='${productId}']`).value = data.quantity;
                    document.querySelector(`.cart-item-subtotal[data-product-id='${productId}']`).textContent = '$' + data.subtotal;
                    document.querySelector('.h5.text-burgundy').textContent = '$' + data.total;
                    */
                }
            });
        }
    </script>
</body>
</html> 