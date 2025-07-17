<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wine Catalog - Terravin Wine</title>
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
            transition: var(--transition);
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

        /* Modern Catalog Layout */
        .catalog-main {
            margin-top: 80px;
            padding-bottom: 3rem;
        }
        
        .page-header {
            background: var(--light-bg);
            border-radius: var(--border-radius);
            padding: 2rem;
            margin-bottom: 2.5rem;
            box-shadow: 0 2px 12px rgba(94, 15, 15, 0.08);
            border: 1px solid rgba(200, 169, 126, 0.2);
}

.page-title {
            font-size: 2.2rem;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
            gap: 1rem;
}

        .page-title i {
            color: var(--secondary);
            font-size: 1.8rem;
}

.page-subtitle {
            color: var(--text-dark);
            font-size: 1.1rem;
            margin-bottom: 0;
        }
        
        /* Modern Search and Filter */
        .search-filter-container {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
}

.search-container {
            flex: 1;
            min-width: 300px;
    position: relative;
}

.search-input {
    width: 100%;
            padding: 0.8rem 1rem 0.8rem 3rem;
            border: 1px solid rgba(200, 169, 126, 0.3);
    border-radius: var(--border-radius);
            background: white url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%235e0f0f' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/%3E%3C/svg%3E") no-repeat 1rem center;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}

.search-input:focus {
    outline: none;
            border-color: var(--secondary);
            box-shadow: 0 0 0 3px rgba(200, 169, 126, 0.2);
}

        .filter-btn-group {
            display: flex;
            gap: 0.75rem;
        }
        
        .filter-btn {
            background: white;
    color: var(--primary);
            border: 1px solid rgba(200, 169, 126, 0.3);
    border-radius: var(--border-radius);
            padding: 0.8rem 1.5rem;
    font-weight: 500;
    display: flex;
    align-items: center;
            gap: 0.5rem;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        
        .filter-btn:hover, .filter-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        .filter-btn i {
            font-size: 0.9rem;
}

        /* Modern Category Navigation */
.category-nav {
            margin-bottom: 2.5rem;
}

.category-scroller {
    display: flex;
    gap: 0.75rem;
    overflow-x: auto;
            padding-bottom: 0.75rem;
    scrollbar-width: none;
}

.category-scroller::-webkit-scrollbar {
    display: none;
}

.category-pill {
            background: white;
            color: var(--primary);
            border: 1px solid rgba(200, 169, 126, 0.3);
    border-radius: 2rem;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: 0 2px 8px rgba(94, 15, 15, 0.08);
    text-decoration: none;
    white-space: nowrap;
            flex-shrink: 0;
}

.category-pill.active, .category-pill:hover {
            background: var(--primary);
    color: white;
    border-color: var(--primary);
}

.category-pill .badge {
            background: var(--secondary);
            color: var(--primary);
    font-size: 0.75rem;
            border-radius: 1rem;
            padding: 0.2rem 0.6rem;
            margin-left: 0.5rem;
}

        /* Modern Wine Grid */
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

        /* Modern Category Section */
        .category-section {
            margin-bottom: 4rem;
        }
        
        .category-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(200, 169, 126, 0.3);
}

        .category-title {
            font-size: 1.75rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .category-title i {
            color: var(--secondary);
            font-size: 1.5rem;
}

        /* Modern CTA Section */
.cta-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
    border-radius: var(--border-radius);
            padding: 3rem 2rem;
    margin-top: 3rem;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100" fill="none" opacity="0.03"><path d="M30,10 L50,30 L70,10" stroke="white" stroke-width="2"/></svg>');
            opacity: 0.1;
}

.cta-title {
    font-size: 1.75rem;
    margin-bottom: 1rem;
            color: white;
            position: relative;
}

.cta-subtitle {
            color: rgba(255, 255, 255, 0.9);
    max-width: 600px;
            margin: 0 auto 2rem auto;
            font-size: 1.1rem;
            position: relative;
        }
        
        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            position: relative;
}

/* Responsive Adjustments */
        @media (max-width: 992px) {
            .wine-grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            }
            
            .wine-image-container {
                height: 240px;
            }
        }
        
@media (max-width: 768px) {
            .page-header {
                padding: 1.5rem;
    }
    
            .page-title {
                font-size: 1.8rem;
    }
    
            .category-title {
                font-size: 1.5rem;
    }
    
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
    
            .search-filter-container {
        flex-direction: column;
        gap: 1rem;
    }
            
            .search-container {
                min-width: 100%;
            }
            
            .filter-btn-group {
                flex-wrap: wrap;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .cta-buttons .btn {
                width: 100%;
                max-width: 280px;
            }
        }

        /* Wine-themed buttons */
        .btn, button, .btn-view-all {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            border-radius: 2rem;
            border: none;
            outline: none;
            box-shadow: none;
            transition: background 0.2s, color 0.2s, border 0.2s;
            padding: 0.5rem 1.5rem;
            font-size: 1rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
    }
        .btn-primary, .btn-view-all, .btn-wine {
            background: var(--primary);
            color: #fff;
            border: 2px solid var(--primary);
        }
        .btn-primary:hover, .btn-view-all:hover, .btn-wine:hover {
            background: var(--primary-light);
            color: var(--secondary);
            border-color: var(--primary-light);
    }
        .btn-secondary, .btn-outline-primary {
            background: #fff;
            color: var(--primary);
            border: 2px solid var(--secondary);
        }
        .btn-secondary:hover, .btn-outline-primary:hover {
            background: var(--secondary);
            color: var(--primary);
            border-color: var(--primary);
        }
        .btn:focus, button:focus, .btn-view-all:focus {
            outline: 2px solid var(--secondary);
            outline-offset: 2px;
        }
        /* Make sure all buttons are highly visible */
        .btn, button, .btn-view-all {
            box-shadow: 0 2px 8px rgba(94, 15, 15, 0.08);
        }
        /* Specific for .btn-view-all if needed */
        .btn-view-all {
            min-width: 110px;
            justify-content: center;
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
</style>
</head>
<body>
    <!-- Modern Wine Navigation -->
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
                            <li><a href="{{ route('customer.products') }}" class="nav-link active"><i class="fas fa-shopping-bag"></i> Wine Shop</a></li>
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
    
    <!-- Main Catalog Content -->
    <main class="catalog-main">
        <div class="container">
            <!-- Modern Page Header -->
            <header class="page-header">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-4">
                    <div>
                        <h1 class="page-title">
                            <i class="fas fa-wine-bottle"></i>
                            <span>Wine Catalog</span>
                        </h1>
                        <p class="page-subtitle">Discover our exquisite collection of fine wines from around the world</p>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="time-badge bg-light px-3 py-2 rounded-pill">
                            <i class="fas fa-clock me-1 text-muted"></i>
                            <span class="text-dark">{{ now()->format('M d, Y') }}</span>
                        </div>
                        <a href="{{ route('orders.create') }}" class="btn btn-primary px-4">
                            <i class="fas fa-shopping-cart me-2"></i>New Order
                        </a>
                    </div>
                </div>
            </header>
            
            <!-- Modern Search and Filter -->
            <div class="search-filter-container">
                <div class="search-container">
                    <input type="text" placeholder="Search wines, regions, vintages..." class="search-input">
                </div>
                <div class="filter-btn-group">
                    <button class="filter-btn active">
                        <i class="fas fa-filter"></i> All Wines
                    </button>
                    <button class="filter-btn">
                        <i class="fas fa-star"></i> Premium
                    </button>
                    <button class="filter-btn">
                        <i class="fas fa-fire"></i> Trending
                    </button>
                </div>
            </div>
            
            <!-- Modern Category Navigation -->
            <nav class="category-nav">
                <div class="category-scroller">
                    <a href="#all-wines" class="category-pill all-wines-pill active">All Wines</a>
                    @php $addedCategories = []; @endphp
                    @foreach($categories as $category => $wines)
                        @php $slug = Str::slug($category); @endphp
                        @if(!isset($addedCategories[$slug]))
                            <a href="#{{ $slug }}" class="category-pill{{ $slug === 'red-wine' ? ' red-wine-pill' : '' }}{{ $slug === 'white-wine' ? ' white-wine-pill' : '' }}">
                                {{ $category }}
                            </a>
                            @php $addedCategories[$slug] = true; @endphp
                        @endif
                    @endforeach
                </div>
            </nav>
            
            <!-- Wine Categories -->
            <div class="wine-catalog-container">
                @foreach($categories as $category => $wines)
                <section id="{{ Str::slug($category) }}" class="category-section">
                    <div class="category-header">
                        <h2 class="category-title">
                            <i class="fas fa-tags"></i>
                            {{ $category }}
                        </h2>
                    </div>
                    
                    <div class="wine-grid">
                        @foreach($wines as $wine)
                        <div class="wine-card">
                            <!-- Wine Image with Floating Badges -->
                            <div class="wine-image-container">
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
                                    @if($wine->isLowStock())
                                    <span class="badge stock-warning">Low Stock</span>
                                    @endif
                                    <span class="badge">{{ $wine->vintage }}</span>
                                </div>
                            </div>
                            
                            <!-- Wine Details -->
                            <div class="wine-details">
                                <h3 class="wine-name">{{ $wine->name }}</h3>
                                <p class="wine-description">{{ Str::limit($wine->description, 120) }}</p>
                                
                                <div class="wine-meta">
                                    <div class="meta-item">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        <span>{{ $wine->region }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-wine-glass me-1"></i>
                                        <span>{{ $wine->varietal }}</span>
                                    </div>
                                </div>
                                
                                <div class="wine-stats">
                                    <div class="wine-price">
                                        ${{ number_format($wine->unit_price, 2) }}
                                    </div>
                                    <div class="wine-stock {{ $wine->isLowStock() ? 'low-stock' : 'in-stock' }}">
                                        {{ $wine->quantity }} in stock
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Wine Actions -->
                            <div class="wine-actions">
                                <button class="btn btn-wine btn-wine-outline btn-quick-view">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <button class="btn btn-wine btn-wine-primary btn-add-to-cart" data-wine-id="{{ $wine->id }}">
                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>
                @endforeach
            </div>
            
            <!-- Modern CTA Section -->
            <section class="cta-section">
                <h3 class="cta-title">Need help selecting the perfect wine?</h3>
                <p class="cta-subtitle">Our expert sommeliers are available to guide you through our collection and help you find the ideal pairing for any occasion.</p>
                <div class="cta-buttons">
                    <a href="{{ route('orders.create') }}" class="btn btn-light btn-lg px-4">
                        <i class="fas fa-shopping-cart me-2"></i> Start Your Order
                    </a>
                    <button class="btn btn-outline-light btn-lg px-4">
                        <i class="fas fa-phone me-2"></i> Contact Sommelier
                    </button>
                </div>
            </section>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryLinks = document.querySelectorAll('.category-pill');
    const categorySections = document.querySelectorAll('.category-section');
    const allWinesBtn = document.querySelector('.all-wines-pill');

    categoryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            categoryLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            if (this.classList.contains('all-wines-pill')) {
                // Show all sections
                categorySections.forEach(section => section.style.display = '');
            } else {
                // Hide all, show only selected
                categorySections.forEach(section => section.style.display = 'none');
                const targetId = this.getAttribute('href');
                const targetSection = document.querySelector(targetId);
                if (targetSection) {
                    targetSection.style.display = '';
                    window.scrollTo({
                        top: targetSection.offsetTop - 120,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
    // On page load, show all
    categorySections.forEach(section => section.style.display = '');
    
    // Quick view button functionality
    const quickViewButtons = document.querySelectorAll('.btn-quick-view');
    
    quickViewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const wineCard = this.closest('.wine-card');
            const wineName = wineCard.querySelector('.wine-name').textContent;
            showNotification(`Showing details for ${wineName}`);
        });
    });
    
    // Add to cart button functionality
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
                    showNotification('Added to cart!');
                    // Visual feedback
                    this.innerHTML = '<i class="fas fa-check me-1"></i> Added';
                    this.classList.add('btn-success');
                    setTimeout(() => {
                        this.innerHTML = '<i class="fas fa-cart-plus me-1"></i> Add to Cart';
                        this.classList.remove('btn-success');
                        this.classList.add('btn-wine-primary');
                    }, 2000);
                    // Update cart counter reliably
                    let cartCount = document.querySelector('.cart-count-badge');
                    if(cartCount) cartCount.textContent = parseInt(cartCount.textContent||'0') + 1;
                } else {
                    showNotification('Error: ' + (data.message || 'Could not add to cart'));
                }
            })
            .catch(err => {
                showNotification('Error: Could not add to cart');
            });
        });
    });
        
        // Filter button functionality
        const filterButtons = document.querySelectorAll('.filter-btn');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                showNotification(`Filtering wines...`);
        });
    });
    
    // Notification function
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

// Add notification styles dynamically
const style = document.createElement('style');
style.textContent = `
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
`;
document.head.appendChild(style);
</script>
</body>
</html>