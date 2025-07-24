<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retailer Inventory | TERRAVIN</title>
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
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
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
        .profile-photo-placeholder-large {
            width: 72px !important;
            height: 72px !important;
            border-width: 6px !important;
            border-color: var(--gold) !important;
            background: linear-gradient(135deg, var(--burgundy) 0%, #8b1a1a 100%);
            color: #fff;
            font-size: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .user-name {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #fff;
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
                            <li><a href="{{ route('retailer.inventory') }}" class="nav-link active"><i class="fas fa-boxes"></i> Inventory</a></li>
                            <li><a href="{{ route('retailer.catalog') }}" class="nav-link"><i class="fas fa-store"></i> Product Catalog</a></li>
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
                            <div class="profile-photo-placeholder-large rounded-circle d-flex align-items-center justify-content-center me-2">
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
            <h1 class="page-title mb-4">Wine Inventory Management</h1>
            <div class="card wine-card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-wine-bottle text-gold me-2"></i> Wine Inventory List
                    </h5>
                </div>
                <div class="card-body">
                    @if($items->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-burgundy fw-bold">#</th>
                                        <th class="text-burgundy fw-bold">Image</th>
                                        <th class="text-burgundy fw-bold">Wine Name</th>
                                        <th class="text-burgundy fw-bold">SKU</th>
                                        <th class="text-burgundy fw-bold">Category</th>
                                        <th class="text-burgundy fw-bold">Quantity</th>
                                        <th class="text-burgundy fw-bold">Price</th>
                                        <th class="text-burgundy fw-bold">Location</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                    <tr class="wine-list-item">
                                        <td>
                                            <span class="badge bg-burgundy text-gold" style="color: var(--gold); background: var(--burgundy);">{{ ($items->firstItem() ?? 0) + $loop->index }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $imgPath = is_array($item->images) ? ($item->images[0] ?? null) : $item->images;
                                            @endphp
                                            @if($imgPath)
                                                @if(Str::startsWith($imgPath, 'inventory_images/'))
                                                    <img src="{{ asset('storage/' . $imgPath) }}" alt="Image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #ccc;">
                                                @else
                                                    <img src="{{ asset('wine_images/' . $imgPath) }}" alt="Image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #ccc;">
                                                @endif
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <strong class="text-burgundy">{{ $item->name }}</strong>
                                                @if($item->quantity < 10)
                                                    <span class="badge bg-danger ms-2">Low Stock</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <code class="text-gold">{{ $item->sku }}</code>
                                        </td>
                                        <td>
                                            <span class="badge bg-gold text-burgundy" style="color: var(--burgundy); background: var(--gold);">{{ $item->category }}</span>
                                        </td>
                                        <td>
                                            @if($item->quantity > 20)
                                                <span class="badge bg-success">{{ $item->quantity }}</span>
                                            @elseif($item->quantity > 10)
                                                <span class="badge bg-warning text-dark">{{ $item->quantity }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ $item->quantity }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong class="text-burgundy">${{ number_format($item->unit_price, 2) }}</strong>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $item->location ?? 'Main Storage' }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($items->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $items->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <div class="icon-circle bg-burgundy mx-auto mb-3">
                                <i class="fas fa-boxes fa-2x text-gold"></i>
                            </div>
                            <h5 class="text-burgundy fw-bold">No wine items found</h5>
                            <p class="text-muted">No inventory items available for your retail account.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 