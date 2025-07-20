<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog | TERRAVIN</title>
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
        .wine-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            transition: var(--transition);
            border: 1px solid rgba(200, 169, 126, 0.2);
        }
        .wine-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }
        .wine-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .wine-image-placeholder {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, var(--burgundy) 0%, var(--light-burgundy) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            font-size: 3rem;
        }
        .wine-badges {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
        .stock-warning {
            background: #ffc107;
            color: #000;
        }
        .wine-details {
            padding: 1.5rem;
        }
        .wine-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            color: var(--burgundy);
            margin-bottom: 0.5rem;
        }
        .wine-description {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        .wine-meta {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .meta-item {
            display: flex;
            align-items: center;
            font-size: 0.85rem;
            color: #666;
        }
        .wine-stats {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        .wine-price {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--burgundy);
        }
        .wine-stock {
            font-size: 0.85rem;
            padding: 0.25rem 0.5rem;
            border-radius: 1rem;
        }
        .in-stock {
            background: #d4edda;
            color: #155724;
        }
        .low-stock {
            background: #fff3cd;
            color: #856404;
        }
        .btn-order {
            background: var(--burgundy);
            color: white;
            border: none;
            border-radius: 2rem;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            transition: var(--transition);
        }
        .btn-order:hover {
            background: var(--light-burgundy);
            color: white;
            transform: translateY(-2px);
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
                            <li><a href="{{ route('retailer.orders') }}" class="nav-link"><i class="fas fa-shopping-bag"></i> Orders</a></li>
                            <li><a href="{{ route('retailer.inventory') }}" class="nav-link"><i class="fas fa-boxes"></i> Inventory</a></li>
                            <li><a href="{{ route('retailer.catalog') }}" class="nav-link active"><i class="fas fa-store"></i> Product Catalog</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="d-flex align-items-center gap-4">
                    <a href="{{ route('retailer.cart') }}" class="btn btn-outline-light position-relative">
                        <i class="fas fa-shopping-cart"></i>
                        @php
                            $cartCount = count(session()->get('retailer_cart', []));
                        @endphp
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                    <div class="dropdown">
                        <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="profile-photo-placeholder-large rounded-circle d-flex align-items-center justify-content-center me-2" style="border: 6px solid var(--gold); background: linear-gradient(135deg, var(--burgundy) 0%, #8b1a1a 100%); width: 72px; height: 72px; color: #fff; font-size: 2rem;">
                                <span class="fw-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                            <span class="user-name" style="color: #fff;">{{ Auth::user()->name }} <span class="text-gold" style="font-weight: 500; color: var(--gold);">(Retailer)</span></span>
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

    <!-- Wine Grid -->
    <div class="row">
        @forelse($wines as $wine)
            <div class="col-md-4 mb-4">
                <div class="card wine-card shadow border-0 h-100">
                    <img src="{{ $wine->image_url ?? 'https://images.unsplash.com/photo-1514361892635-cebb9b6c7ca5?auto=format&fit=crop&w=400&q=80' }}" class="card-img-top" alt="{{ $wine->name }}" style="height: 220px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-burgundy">{{ $wine->name }}</h5>
                        <p class="card-text text-muted">{{ $wine->description }}</p>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-gold" style="color: #b85c38; font-size: 1.2rem;">{{ 'UGX ' . number_format($wine->price, 0) }}</span>
                            <a href="#" class="btn wine-btn" style="background: #b85c38; color: #fff;"><i class="fas fa-cart-plus me-1"></i> Add to Order</a>
                        </div>
                    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="page-title mb-0">Product Catalog</h1>
                <div class="d-flex gap-3">
                    @php
                        $cartCount = count(session()->get('retailer_cart', []));
                    @endphp
                    @if($cartCount > 0)
                        <a href="{{ route('retailer.cart') }}" class="btn btn-burgundy">
                            <i class="fas fa-shopping-cart me-2"></i>View Cart ({{ $cartCount }})
                        </a>
                    @endif
                    <span class="badge bg-gold text-burgundy px-3 py-2" style="color: var(--burgundy); background: var(--gold);">
                        <i class="fas fa-clock me-1"></i>
                        {{ now()->format('M d, Y H:i') }}
                    </span>
                </div>
            </div>
            <!-- Wine Grid -->
            <div class="row">
                @forelse($wines as $wine)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="wine-card">
                            <div class="position-relative">
                                @if(!empty($wine->images) && is_array($wine->images) && count($wine->images) > 0)
                                    @php $imgPath = $wine->images[0]; @endphp
                                    @if(Str::startsWith($imgPath, 'inventory_images/'))
                                        <img src="{{ asset('storage/' . $imgPath) }}" alt="{{ $wine->name }}" class="wine-image">
                                    @else
                                        <img src="{{ asset('wine_images/' . $imgPath) }}" alt="{{ $wine->name }}" class="wine-image">
                                    @endif
                                @else
                                    <div class="wine-image-placeholder">
                                        <i class="fas fa-wine-bottle"></i>
                                    </div>
                                @endif
                                <div class="wine-badges">
                                    @if($wine->quantity <= 10)
                                        <span class="badge stock-warning">Low Stock</span>
                                    @endif
                                </div>
                            </div>
                            <div class="wine-details">
                                <h3 class="wine-name">{{ $wine->name }}</h3>
                                <p class="wine-description">{{ Str::limit($wine->description, 100) }}</p>
                                <div class="wine-meta">
                                    <div class="meta-item">
                                        <i class="fas fa-barcode me-1"></i>
                                        <span>{{ $wine->sku }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-wine-glass me-1"></i>
                                        <span>{{ $wine->category ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                <div class="wine-stats">
                                    <div class="wine-price">${{ number_format($wine->unit_price, 2) }}</div>
                                    <div class="wine-stock {{ $wine->quantity <= 10 ? 'low-stock' : 'in-stock' }}">
                                        {{ $wine->quantity }} in stock
                                    </div>
                                </div>
                                <button class="btn btn-order w-100" onclick="addToOrder({{ $wine->id }}, '{{ $wine->name }}')">
                                    <i class="fas fa-cart-plus me-2"></i>Add to Order
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle fa-2x mb-3"></i>
                            <h4>No products found</h4>
                            <p>Try adjusting your search criteria or check back later for new products.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.innerHTML = `<div class="notification-content"><i class="fas fa-check-circle"></i><span>${message}</span></div>`;
    document.body.appendChild(notification);
    setTimeout(() => { notification.classList.add('show'); }, 10);
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => { document.body.removeChild(notification); }, 300);
    }, 2000);
}
function addToOrder(wineId, wineName) {
    fetch('/retailer/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ wine_id: wineId, quantity: 1 })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            showNotification('Added to order!');
            // Visual feedback
            const btn = document.querySelector(`button[onclick*="addToOrder(${wineId}"]`);
            if(btn) {
                btn.innerHTML = '<i class="fas fa-check me-2"></i>Added';
                btn.classList.add('btn-success');
                setTimeout(() => {
                    btn.innerHTML = '<i class="fas fa-cart-plus me-2"></i>Add to Order';
                    btn.classList.remove('btn-success');
                }, 2000);
            }
            // Update cart counter
            let cartCount = document.querySelectorAll('.cart-count-badge');
            cartCount.forEach(function(el) {
                el.textContent = parseInt(el.textContent||'0') + 1;
            });
        } else {
            showNotification('Error: Could not add to order');
        }
    })
    .catch(() => showNotification('Error: Could not add to order'));
}
// Notification styles
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
</script>
</body>
</html> 