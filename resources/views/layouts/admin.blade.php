<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', config('app.name', 'Terravin Wine Supply Management'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap & FontAwesome -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        <!-- Wine-themed top bar -->
        <div class="wine-top-bar">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-2">
                        <a class="wine-brand" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-wine-bottle"></i>
                        </a>
                    </div>
                    <div class="col-md-7">
                        <nav class="wine-nav">
                            <ul class="nav-links">
                                <li><a href="{{ route('dashboard') }}" class="nav-link">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a></li>
                                @permission('manage_inventory')
                                <li><a href="{{ route('inventory.index') }}" class="nav-link">
                                    <i class="fas fa-boxes"></i> Inventory
                                </a></li>
                                @endpermission
                                @permission('manage_procurement')
                                <li><a href="{{ route('procurement.dashboard') }}" class="nav-link">
                                    <i class="fas fa-shopping-cart"></i> Procurement
                                </a></li>
                                @endpermission
                                @permission('view_orders')
                                <li><a href="{{ route('orders.index') }}" class="nav-link">
                                    <i class="fas fa-shopping-bag"></i> Orders
                                </a></li>
                                @endpermission
                                @permission('manage_logistics')
                                <li><a href="{{ route('logistics.dashboard') }}" class="nav-link">
                                    <i class="fas fa-truck"></i> Logistics
                                </a></li>
                                @endpermission
                                @if(Auth::user()->role === 'Supplier' || Auth::user()->role === 'Customer')
                                <li><a href="{{ route('chat.index') }}" class="nav-link">
                                    <i class="fas fa-comments"></i> Chat
                                </a></li>
                                @endif
                                @role('Admin')
                                <li><a href="{{ route('admin.manage-roles') }}" class="nav-link">
                                    <i class="fas fa-users-cog"></i> Users
                                </a></li>
                                @endrole
                            </ul>
                        </nav>
                    </div>
                    <div class="col-md-3 text-end">
                        <div class="user-info">
                            @auth
                                <span class="user-name">{{ Auth::user()->name }}</span>
                                <span class="user-role">({{ ucfirst(strtolower(Auth::user()->role)) }})</span>
                                <a href="{{ route('logout') }}" class="logout-btn" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        @stack('scripts')

        <style>
        :root {
            --burgundy: #5e0f0f;
            --gold: #c8a97e;
            --cream: #f5f0e6;
            --light-burgundy: #8b1a1a;
            --dark-gold: #b8945f;
        }

        body {
            background-color: var(--cream);
            margin: 0;
            padding: 0;
        }

        .wine-top-bar {
            background: linear-gradient(135deg, var(--burgundy) 0%, var(--light-burgundy) 100%);
            color: white;
            padding: 0.75rem 0;
            box-shadow: 0 2px 10px rgba(94, 15, 15, 0.2);
            position: sticky;
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

        .user-role {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }

        .logout-btn {
            color: var(--gold);
            text-decoration: none;
            padding: 0.25rem 0.75rem;
            border: 1px solid var(--gold);
            border-radius: 20px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .logout-btn:hover {
            background-color: var(--gold);
            color: var(--burgundy);
            text-decoration: none;
        }

        .main-content {
            padding: 2rem 0;
            min-height: calc(100vh - 70px);
        }

        @media (max-width: 1200px) {
            .nav-links {
                gap: 1rem;
            }
            
            .nav-link {
                font-size: 0.8rem;
                padding: 0.4rem 0.6rem;
            }
        }

        @media (max-width: 992px) {
            .wine-nav {
                display: none;
            }
            
            .col-md-4 {
                flex: 0 0 50%;
                max-width: 50%;
            }
            
            .col-md-3 {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }

        @media (max-width: 768px) {
            .user-info {
                flex-direction: column;
                gap: 0.5rem;
                text-align: center;
            }
            
            .wine-brand {
                font-size: 1rem;
            }
            
            .nav-links {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
        </style>
    </body>
</html> 