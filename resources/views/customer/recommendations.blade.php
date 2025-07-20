@extends('layouts.minimal')

@section('title', 'Recommended For You')

@push('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #5e0f0f;
            --primary-light: #8b1a1a;
            --secondary: #c8a97e;
            --cream: #f5f0e6;
            --light-bg: #f9f5ed;
            --text-dark: #2a2a2a;
            --border-radius: 18px;
            --shadow-md: 0 4px 24px rgba(94, 15, 15, 0.13);
        }
        body {
            font-family: 'Montserrat', sans-serif;
            color: var(--text-dark);
            background-color: var(--cream);
            line-height: 1.6;
        }
        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: var(--primary);
        }
        /* Modern Navigation */
        .wine-top-bar {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
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
            color: var(--secondary);
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: 600;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .wine-brand:hover {
            color: white;
            text-decoration: none;
        }
        .nav-links {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }
        .nav-link {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            font-size: 0.95rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
        }
        .nav-link:hover {
            color: var(--secondary);
            background-color: rgba(200, 169, 126, 0.1);
            text-decoration: none;
        }
        .nav-link.active {
            color: var(--secondary);
        }
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 5px;
            height: 5px;
            background-color: var(--secondary);
            border-radius: 50%;
        }
        .cart-link {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.2rem 0.7rem;
            border-radius: 50px;
            background: rgba(200, 169, 126, 0.08);
            transition: background 0.2s;
            position: relative;
        }
        .cart-link:hover {
            background: rgba(200, 169, 126, 0.18);
        }
        .cart-icon-container {
            position: relative;
            display: inline-block;
        }
        .cart-count-badge {
            position: absolute;
            top: -8px;
            right: -12px;
            background: var(--primary);
            color: #fff;
            border-radius: 50%;
            padding: 0.25em 0.6em;
            font-size: 1rem;
            font-weight: bold;
            border: 2px solid #fff;
            box-shadow: 0 2px 8px rgba(94,15,15,0.15);
            z-index: 2;
            transition: background 0.2s;
        }
        .cart-icon-container:hover .cart-count-badge {
            background: #7b2230;
        }
        .profile-photo-large {
            width: 72px !important;
            height: 72px !important;
            border-width: 6px !important;
            border-color: var(--secondary) !important;
            object-fit: cover;
        }
        .profile-photo-placeholder-large {
            width: 72px !important;
            height: 72px !important;
            border-width: 6px !important;
            border-color: var(--secondary) !important;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: #fff;
            font-size: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .user-name {
            color: var(--secondary) !important;
            font-weight: 600;
            font-size: 1.1rem;
        }
        .wine-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }
        .wine-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 8px rgba(94, 15, 15, 0.08);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            border: 1px solid rgba(200, 169, 126, 0.2);
        }
        .wine-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }
        .wine-image-container {
            position: relative;
            width: 100%;
            height: 280px;
            background: var(--cream);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .wine-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .wine-card:hover .wine-image {
            transform: scale(1.05);
        }
        .wine-image-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 3rem;
            opacity: 0.3;
        }
        .wine-badges {
            position: absolute;
            top: 1rem;
            left: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            z-index: 2;
        }
        .badge {
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.3rem 0.8rem;
            border-radius: 1rem;
            background: var(--secondary);
            color: var(--primary);
            box-shadow: 0 2px 8px rgba(94, 15, 15, 0.08);
        }
        .stock-warning {
            background: #fff3cd;
            color: #856404;
        }
        .wine-details {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .wine-name {
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
            line-height: 1.3;
        }
        .wine-description {
            font-size: 0.95rem;
            color: var(--text-dark);
            margin-bottom: 1rem;
            flex: 1;
        }
        .wine-meta {
            display: flex;
            gap: 1.5rem;
            font-size: 0.9rem;
            color: var(--primary-light);
            margin-bottom: 1rem;
        }
        .wine-stats {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
        }
        .wine-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
        }
        .wine-stock {
            font-size: 0.9rem;
            color: var(--text-dark);
        }
        .wine-stock.in-stock {
            color: #28a745;
        }
        .wine-stock.low-stock {
            color: #fd7e14;
        }
        .wine-actions {
            display: flex;
            gap: 0.75rem;
            padding: 0 1.5rem 1.5rem 1.5rem;
        }
        .btn-wine {
            border-radius: 2rem;
            padding: 0.6rem 1.25rem;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .btn-wine-primary {
            background: var(--primary);
            border-color: var(--primary);
        }
        .btn-wine-primary:hover {
            background: var(--primary-light);
            border-color: var(--primary-light);
        }
        .btn-wine-outline {
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
        }
        .btn-wine-outline:hover {
            background: rgba(94, 15, 15, 0.05);
        }
        @media (max-width: 992px) {
            .wine-grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            }
            .wine-image-container {
                height: 240px;
            }
        }
        @media (max-width: 768px) {
            .wine-grid {
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
                gap: 1.5rem;
            }
            .wine-details {
                padding: 1.25rem;
            }
        }
        @media (max-width: 576px) {
            .wine-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
<!-- Modern Wine Navigation/Header (copied from main catalog) -->
<div class="wine-top-bar">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between" style="min-height: 80px;">
            <div class="d-flex align-items-center gap-3">
                <a class="wine-brand" href="{{ route('customer.dashboard') }}">
                    <i class="fas fa-wine-bottle"></i>
                </a>
                <nav class="wine-nav">
                    <ul class="nav-links d-flex align-items-center gap-3 mb-0" style="list-style:none;">
                        <li><a href="{{ route('customer.dashboard') }}" class="nav-link"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                        <li><a href="{{ route('customer.products') }}" class="nav-link"><i class="fas fa-shopping-bag"></i> Wine Shop</a></li>
                        <li><a href="{{ route('customer.favorites') }}" class="nav-link"><i class="fas fa-heart"></i> Favorites</a></li>
                        <li><a href="{{ route('customer.orders') }}" class="nav-link"><i class="fas fa-history"></i> Orders</a></li>
                        <li><a href="{{ route('help.index') }}" class="nav-link"><i class="fas fa-question-circle"></i> Help</a></li>
                    </ul>
                </nav>
            </div>
            <div class="d-flex align-items-center gap-4">
                @php
                    $cartCount = \App\Models\CartItem::where('user_id', Auth::id())->sum('quantity');
                @endphp
                <a href="{{ route('cart.index') }}" class="cart-link" style="display:inline-block;">
                    <span class="cart-icon-container">
                        <i class="fas fa-shopping-cart" style="font-size:2.2rem;color:var(--secondary);"></i>
                        <span class="cart-count-badge">{{ $cartCount }}</span>
                    </span>
                </a>
                @auth
                <div class="dropdown">
                    <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#" role="button" data-bs-toggle="dropdown">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}?v={{ time() }}" alt="{{ Auth::user()->name }}" class="profile-photo-large rounded-circle me-2" style="border: 6px solid var(--secondary);">
                        @else
                            <div class="profile-photo-placeholder-large rounded-circle d-flex align-items-center justify-content-center me-2" style="border: 6px solid var(--secondary); background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); width: 72px; height: 72px; color: #fff; font-size: 2rem;">
                                <span class="fw-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
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
<!-- Modern Page Header -->
<div class="container" style="margin-top: 100px;">
    <header class="page-header">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-4">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-magic"></i>
                    <span>Recommended For You</span>
                </h1>
                <p class="page-subtitle">Personalized wine recommendations based on your preferences and purchase history</p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="time-badge bg-light px-3 py-2 rounded-pill">
                    <i class="fas fa-clock me-1 text-muted"></i>
                    <span class="text-dark">{{ now()->format('M d, Y') }}</span>
                </div>
                <a href="{{ route('orders.catalog') }}" class="btn btn-wine btn-wine-outline mb-4" style="min-width: 180px; display: inline-flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-arrow-left"></i> Back to Catalog
                </a>
            </div>
        </div>
    </header>
</div>
    @if($error)
        <div class="alert alert-danger">{{ $error }}</div>
    @elseif(empty($recommendations))
        <div class="alert alert-info">No recommendations found at this time. Please check back later!</div>
    @else
        <div class="wine-grid">
            @foreach($recommendations as $rec)
                <div class="wine-card">
                    <div class="wine-image-container">
                        @if(!empty($rec['IMAGE']))
                            <img src="{{ asset('wine_images/' . $rec['IMAGE']) }}" alt="{{ $rec['WINE NAME'] ?? 'Wine' }}" class="wine-image">
                        @else
                            <div class="wine-image-placeholder">
                                <i class="fas fa-wine-bottle"></i>
                            </div>
                        @endif
                        <div class="wine-badges">
                            @if(!empty($rec['LOW_STOCK']) && $rec['LOW_STOCK'])
                                <span class="badge stock-warning">Low Stock</span>
                            @endif
                            @if(!empty($rec['VINTAGE']))
                                <span class="badge">{{ $rec['VINTAGE'] }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="wine-details">
                        <h3 class="wine-name">{{ $rec['WINE NAME'] ?? 'Wine' }}</h3>
                        <p class="wine-description">{{ Str::limit($rec['DESCRIPTION'] ?? '', 120) }}</p>
                        <div class="wine-meta">
                            <div class="meta-item">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                <span>{{ $rec['REGION'] ?? '' }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-wine-glass me-1"></i>
                                <span>{{ $rec['VARIETAL'] ?? '' }}</span>
                            </div>
                        </div>
                        <div class="wine-stats">
                            <div class="wine-price">
                                ${{ number_format($rec['PRICE PER UNIT'] ?? 0, 2) }}
                            </div>
                            <div class="wine-stock {{ (!empty($rec['LOW_STOCK']) && $rec['LOW_STOCK']) ? 'low-stock' : 'in-stock' }}">
                                {{ $rec['QUANTITY'] ?? '' }} in stock
                            </div>
                        </div>
                    </div>
                    <div class="wine-actions">
                        <button class="btn btn-wine btn-wine-outline btn-quick-view">
                            <i class="fas fa-eye"></i> View
                        </button>
                        <button class="btn btn-wine btn-wine-primary btn-add-to-cart" data-wine-id="{{ $rec['ID'] ?? '' }}" style="color: #fff;">
                            <i class="fas fa-cart-plus"></i> Add to Cart
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add to Cart functionality (already present)
    const addToCartButtons = document.querySelectorAll('.btn-add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const wineId = this.getAttribute('data-wine-id');
            fetch('/cart/add', {
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
                    this.innerHTML = '<i class="fas fa-check me-1"></i> Added';
                    this.classList.add('btn-success');
                    setTimeout(() => {
                        this.innerHTML = '<i class="fas fa-cart-plus me-1"></i> Add to Cart';
                        this.classList.remove('btn-success');
                        this.classList.add('btn-wine-primary');
                    }, 2000);
                    let cartCount = document.querySelector('.cart-count-badge');
                    if(cartCount) cartCount.textContent = parseInt(cartCount.textContent||'0') + 1;
                } else {
                    alert('Error: ' + (data.message || 'Could not add to cart'));
                }
            })
            .catch(err => {
                alert('Error: Could not add to cart');
            });
        });
    });

    // View button functionality (show notification)
    const quickViewButtons = document.querySelectorAll('.btn-quick-view');
    quickViewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const wineCard = this.closest('.wine-card');
            const wineName = wineCard.querySelector('.wine-name').textContent;
            showNotification(`Showing details for ${wineName}`);
        });
    });

    function showNotification(message) {
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-check-circle"></i>
                <span>${message}</span>
            </div>
        `;
        document.body.appendChild(notification);
        setTimeout(() => {
            notification.classList.add('show');
        }, 10);
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }
});
</script>
<style>
.notification {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: var(--primary);
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
    color: var(--secondary);
}
</style>
@endpush 