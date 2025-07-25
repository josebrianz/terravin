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
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
        <style>
            :root {
                --burgundy: #5e0f0f;
                --gold: #c8a97e;
                --cream: #f5f0e6;
                --dark-text: #2a2a2a;
                --light-text: #f8f8f8;
            }
            .navbar, .navbar.bg-primary {
                background: var(--burgundy) !important;
                border-bottom: 2px solid var(--gold);
            }
            .navbar .navbar-brand, .navbar .nav-link, .navbar .dropdown-item {
                color: var(--gold) !important;
                font-family: 'Playfair Display', serif;
                font-size: 1.1rem;
            }
            .navbar .nav-link.active, .navbar .nav-link:focus, .navbar .nav-link:hover, .navbar .dropdown-item:focus, .navbar .dropdown-item:hover {
                color: var(--cream) !important;
                background: var(--gold) !important;
            }
            .navbar .navbar-brand {
                font-size: 1.5rem;
                font-weight: bold;
                letter-spacing: 2px;
            }
            .dropdown-menu {
                background: var(--cream) !important;
                border: 1px solid var(--gold);
            }
            .dropdown-item {
                color: var(--burgundy) !important;
            }
            .dropdown-item.active, .dropdown-item:active {
                background: var(--gold) !important;
                color: var(--burgundy) !important;
            }
            header.bg-white.shadow {
                background: var(--gold) !important;
                color: var(--burgundy) !important;
                box-shadow: 0 2px 8px rgba(94, 15, 15, 0.08);
                border-bottom: 2px solid var(--burgundy);
            }
            header .max-w-7xl h2, header .max-w-7xl h1, header .max-w-7xl {
                color: var(--burgundy) !important;
                font-family: 'Playfair Display', serif;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                @if(Auth::check() && Auth::user()->hasRole('Vendor'))
                    <!-- Vendor Responsive Navigation Bar -->
                    <a class="navbar-brand" href="{{ url('/vendor/dashboard') }}">
                        <i class="fas fa-wine-bottle"></i> Terravin
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#vendorNavbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="vendorNavbarNav">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/vendor/dashboard') }}">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/vendor/orders') }}">
                                    <i class="fas fa-shopping-bag"></i> Orders
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/vendor/inventory') }}">
                                    <i class="fas fa-boxes"></i> Inventory
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/reports') }}">
                                    <i class="fas fa-chart-line"></i> Analytics
                                </a>
                            </li>
                        </ul>
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="vendorProfileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="profile-photo-placeholder-large rounded-circle d-flex align-items-center justify-content-center me-2" style="border: 4px solid var(--gold); background: linear-gradient(135deg, var(--burgundy) 0%, #8b1a1a 100%); width: 48px; height: 48px; color: #fff; font-size: 1.3rem;">
                                        <span class="fw-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                    </div>
                                    <span class="user-name">{{ Auth::user()->name }} <span class="text-gold" style="font-weight: 500;">(Vendor)</span></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="vendorProfileDropdown">
                                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user-edit me-2"></i> Profile</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                @else
                    <!-- Default Navigation Bar (Admin, Retailer, etc.) -->
                    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-wine-bottle"></i> Terravin
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="procurementDropdown" role="button" 
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-shopping-cart"></i> Procurement
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="procurementDropdown">
                                    <li><a class="dropdown-item" href="{{ route('procurement.dashboard') }}">
                                        <i class="fas fa-chart-bar"></i> Dashboard
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('procurement.index') }}">
                                        <i class="fas fa-list"></i> All Procurements
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('procurement.create') }}">
                                        <i class="fas fa-plus"></i> New Procurement
                                    </a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('inventory.index') }}">
                                    <i class="fas fa-boxes"></i> Inventory
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true" style="pointer-events: none; opacity: 0.6;">
                                    <i class="fas fa-truck"></i> Logistics
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('analytics.dashboard') }}">
                                    <i class="fas fa-chart-bar"></i> Analytics
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
        </nav>

        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    </head>
    <body class="font-sans antialiased">
        @if (!Auth::check())
            <script>
                window.location = "{{ route('login') }}";
            </script>
        @endif
        <script>
            if (window.performance && window.performance.navigation.type === 2) {
                // Type 2 means the user navigated with the back/forward button
                window.location.reload();
            }
        </script>
        @include('components.role-based-nav')
        <div class="min-h-screen bg-gray-100">
            {{-- Remove the navigation include to avoid double navbars for vendor --}}
            @if(!(Auth::check() && Auth::user()->hasRole('Vendor')))
                @include('layouts.navigation')
            @endif

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="py-4">
                @yield('content')
                {{ $slot ?? '' }}
            </main>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        @stack('scripts')
    </body>
</html>
