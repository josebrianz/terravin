<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders | TERRAVIN</title>
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
        .header {
            width: 100%;
            max-width: 700px;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        .greeting {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .user-avatar-sm {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--burgundy);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.2rem;
        }
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--burgundy);
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        .orders-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: 3rem;
            color: #222;
        }
        .orders-placeholder i {
            font-size: 2.5rem;
            color: var(--burgundy);
            margin-bottom: 1rem;
        }
        .orders-placeholder .no-orders {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .orders-placeholder .order-desc {
            color: #666;
            margin-bottom: 1rem;
        }
        .orders-placeholder a {
            color: var(--burgundy);
            font-weight: 500;
            text-decoration: none;
            transition: color 0.2s;
        }
        .orders-placeholder a:hover {
            color: var(--gold);
            text-decoration: underline;
        }
        @media (max-width: 768px) {
            .main-content {
                padding: 1.2rem 0.5rem;
            }
            .header {
                flex-direction: column;
                align-items: flex-start;
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
                            <li><a href="{{ route('customer.orders') }}" class="nav-link active"><i class="fas fa-history"></i> Orders</a></li>
                            <li><a href="{{ route('help.index') }}" class="nav-link"><i class="fas fa-question-circle"></i> Help</a></li>
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
            <div class="header">
                <div class="greeting">
                    <div class="user-avatar-sm">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    <div>
                        <h1 class="section-title"><i class="fas fa-history"></i> My Order History</h1>
                    </div>
                </div>
            </div>
            <div class="container">
                @if($orders->count() > 0)
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="card mb-4">
                                <div class="card-header bg-burgundy text-white">My Orders</div>
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Order #</th>
                                                <th>Date</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                                <tr>
                                                    <td>{{ $order->id }}</td>
                                                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                                    <td>${{ number_format($order->total_amount, 0) }}</td>
                                                    <td>{{ ucfirst($order->status) }}</td>
                                                    <td><a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $orders->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="orders-placeholder">
                        <i class="fas fa-shopping-cart"></i>
                        <div class="no-orders">No orders found</div>
                        <div class="order-desc">You haven't placed any orders yet.</div>
                        <a href="{{ route('customer.products') }}"><i class="fas fa-plus"></i> Shop Wines</a>
                    </div>
                @endif
            </div>
        </main>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 