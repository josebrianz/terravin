<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Reports | TERRAVIN</title>
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
        .dashboard-section {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
        }
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            color: var(--burgundy);
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .stats-cards {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: linear-gradient(135deg, var(--burgundy) 0%, var(--gold) 100%);
            color: #fff;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            padding: 1.5rem 2.2rem;
            min-width: 210px;
            flex: 1 1 210px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        .stat-label {
            font-size: 1.05rem;
            font-weight: 500;
            opacity: 0.92;
        }
        .stat-value {
            font-size: 2.1rem;
            font-weight: 700;
            margin-top: 0.2rem;
        }
        .table-container {
            background: #fff;
            border-radius: var(--border-radius);
            box-shadow: 0 6px 32px rgba(94, 15, 15, 0.10);
            padding: 2rem 1.5rem 2.5rem 1.5rem;
            border: 2px solid var(--burgundy);
            margin-top: 2rem;
        }
        .table {
            font-size: 1.08rem;
            border-radius: var(--border-radius);
            overflow: hidden;
        }
        th {
            background: linear-gradient(90deg, var(--burgundy) 60%, var(--gold) 100%);
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
            border: none;
        }
        td {
            background: #f9f5ed;
            color: var(--dark-text);
            padding: 0.95rem 1.1rem;
            border: none;
        }
        tr:nth-child(even) td {
            background: #f5e6e6;
        }
        .badge-status {
            font-size: 0.98rem;
            border-radius: 1rem;
            padding: 0.4em 1.1em;
            font-weight: 600;
        }
        .badge-pending {
            background: #fff3e6;
            color: #b85c38;
            border: 1.5px solid #c8a97e;
        }
        .badge-approved {
            background: #e6f5e6;
            color: #2e7d32;
            border: 1.5px solid #a5d6a7;
        }
        .badge-shipped {
            background: #e6f0f5;
            color: #1565c0;
            border: 1.5px solid #90caf9;
        }
        .badge-delivered {
            background: #f5fbe6;
            color: #7b9b23;
            border: 1.5px solid #d4e157;
        }
    </style>
</head>
<body>
    <!-- Wine-themed top nav bar for supplier -->
    <div class="wine-top-bar">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between" style="min-height: 80px;">
                <div class="d-flex align-items-center gap-3">
                    <a class="wine-brand" href="{{ url('/supplier/dashboard') }}">
                        <i class="fas fa-wine-bottle"></i>
                    </a>
                    <nav class="wine-nav">
                        <ul class="nav-links d-flex align-items-center gap-3 mb-0" style="list-style:none;">
                            <li><a href="{{ url('/supplier/dashboard') }}" class="nav-link"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                            <li><a href="{{ url('/supplier/raw-materials') }}" class="nav-link"><i class="fas fa-cubes"></i> Raw Materials</a></li>
                            <li><a href="{{ url('/supplier/orders') }}" class="nav-link"><i class="fas fa-clipboard-list"></i> Orders</a></li>
                            <li><a href="{{ url('/supplier/reports') }}" class="nav-link active"><i class="fas fa-chart-bar"></i> Reports</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="d-flex align-items-center gap-4">
                    <div class="dropdown">
                        <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="profile-photo-placeholder-large rounded-circle d-flex align-items-center justify-content-center me-2" style="border: 6px solid var(--gold); background: linear-gradient(135deg, var(--burgundy) 0%, #8b1a1a 100%); width: 72px; height: 72px; color: #fff; font-size: 2rem;">
                                <span class="fw-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                            <span class="user-name">{{ Auth::user()->name }} <span class="text-gold" style="font-weight: 500;">(Supplier)</span></span>
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
            <h1 class="page-title mb-4">Supplier Reports & Analytics</h1>
            <div class="dashboard-section">
                <div class="section-title"><i class="fas fa-chart-bar me-2"></i>Supply Stats</div>
                <div class="stats-cards">
                    <div class="stat-card">
                        <div class="stat-label">Total Orders</div>
                        <div class="stat-value">{{ $supplyStats['totalOrders'] }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Pending Orders</div>
                        <div class="stat-value">{{ $supplyStats['pendingOrders'] }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Delivered Orders</div>
                        <div class="stat-value">{{ $supplyStats['deliveredOrders'] }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Out of Stock Items</div>
                        <div class="stat-value">{{ $supplyStats['outOfStock'] }}</div>
                    </div>
                </div>
            </div>
            <div class="dashboard-section">
                <div class="section-title"><i class="fas fa-cubes me-2"></i>Raw Materials Inventory</div>
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Material Name</th>
                                    <th>Stock</th>
                                    <th>Unit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rawMaterials as $mat)
                                    <tr>
                                        <td>{{ $mat['name'] }}</td>
                                        <td>{{ $mat['stock'] }}</td>
                                        <td>{{ $mat['unit'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="dashboard-section">
                <div class="section-title"><i class="fas fa-clipboard-list me-2"></i>Recent Orders</div>
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Items</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentOrders as $order)
                                    <tr>
                                        <td>#{{ $order['id'] }}</td>
                                        <td>{{ $order['items'] }}</td>
                                        <td>{{ $order['date'] }}</td>
                                        <td>
                                            @if ($order['status'] === 'Pending')
                                                <span class="badge badge-status badge-pending">Pending</span>
                                            @elseif ($order['status'] === 'Approved')
                                                <span class="badge badge-status badge-approved">Approved</span>
                                            @elseif ($order['status'] === 'Shipped')
                                                <span class="badge badge-status badge-shipped">Shipped</span>
                                            @elseif ($order['status'] === 'Delivered')
                                                <span class="badge badge-status badge-delivered">Delivered</span>
                                            @else
                                                <span class="badge badge-status">{{ $order['status'] }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateReports(data) {
            // Update stats
            document.querySelector('.stat-card:nth-child(1) .stat-value').textContent = data.supplyStats.totalOrders;
            document.querySelector('.stat-card:nth-child(2) .stat-value').textContent = data.supplyStats.pendingOrders;
            document.querySelector('.stat-card:nth-child(3) .stat-value').textContent = data.supplyStats.deliveredOrders;
            document.querySelector('.stat-card:nth-child(4) .stat-value').textContent = data.supplyStats.outOfStock;
            // Update raw materials table
            let matRows = '';
            data.rawMaterials.forEach(function(mat) {
                matRows += `<tr><td>${mat.name}</td><td>${mat.stock}</td><td>${mat.unit || ''}</td></tr>`;
            });
            document.querySelector('.dashboard-section:nth-of-type(2) tbody').innerHTML = matRows;
            // Update recent orders table
            let orderRows = '';
            data.recentOrders.forEach(function(order) {
                let badge = '<span class="badge badge-status badge-pending">' + order.status + '</span>';
                if (order.status === 'Approved') badge = '<span class="badge badge-status badge-approved">' + order.status + '</span>';
                if (order.status === 'Shipped') badge = '<span class="badge badge-status badge-shipped">' + order.status + '</span>';
                if (order.status === 'Delivered') badge = '<span class="badge badge-status badge-delivered">' + order.status + '</span>';
                orderRows += `<tr><td>#${order.id}</td><td>${order.items}</td><td>${order.date}</td><td>${badge}</td></tr>`;
            });
            document.querySelector('.dashboard-section:nth-of-type(3) tbody').innerHTML = orderRows;
        }
        function showLoading() {
            document.body.style.cursor = 'wait';
        }
        function hideLoading() {
            document.body.style.cursor = '';
        }
        async function fetchReports() {
            showLoading();
            try {
                const res = await fetch('/api/supplier/reports', {headers: {'Accept': 'application/json'}});
                if (res.ok) {
                    const data = await res.json();
                    updateReports(data);
                }
            } finally {
                hideLoading();
            }
        }
        setInterval(fetchReports, 10000); // Poll every 10 seconds
        window.addEventListener('DOMContentLoaded', fetchReports);
    </script>
</body>
</html> 