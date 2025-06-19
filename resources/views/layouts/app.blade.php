<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Terravin Wine Supply Management')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @stack('styles')
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #f3e9e1 100%);
            font-family: 'Figtree', 'Segoe UI', Arial, sans-serif;
        }
        .navbar-brand {
            font-weight: bold;
            letter-spacing: 1px;
        }
        .navbar {
            box-shadow: 0 2px 8px rgba(44, 37, 24, 0.08);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-wine-bottle me-2"></i>Terravin
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
                        <a class="nav-link" href="{{ route('logistics.dashboard') }}">
                            <i class="fas fa-truck"></i> Logistics
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid px-4">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
