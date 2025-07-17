<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Orders | TERRAVIN</title>
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
        tr:hover td {
            background: #fff3e6;
            color: var(--burgundy);
            transition: background 0.2s, color 0.2s;
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
        .btn-details {
            background: var(--burgundy);
            color: #fff;
            border-radius: 1.5rem;
            font-size: 0.98rem;
            padding: 0.4em 1.2em;
            border: none;
            transition: background 0.2s;
        }
        .btn-details:hover {
            background: var(--gold);
            color: var(--burgundy);
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
                            <li><a href="{{ url('/supplier/orders') }}" class="nav-link active"><i class="fas fa-clipboard-list"></i> Orders</a></li>
                            <li><a href="{{ url('/supplier/reports') }}" class="nav-link"><i class="fas fa-chart-bar"></i> Reports</a></li>
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
            <h1 class="page-title mb-4">Orders from Company</h1>
            <div class="dashboard-section">
                <div class="section-title"><i class="fas fa-clipboard-list me-2"></i>Company Orders to Supplier</div>
                <div class="table-container">
                    <div class="table-title">Order Tracking</div>
                    <div class="table-desc">Below are orders placed by the company (admin) for your supplied raw materials. Track the status of each order and view details as needed.</div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Item(s)</th>
                                    <th>Quantity</th>
                                    <th>Order Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#1001</td>
                                    <td>Grapes, Yeast</td>
                                    <td>2,000 kg, 20 kg</td>
                                    <td>2025-07-15</td>
                                    <td><span class="badge badge-status badge-pending">Pending</span></td>
                                    <td><a href="{{ url('/supplier/orders/1001') }}" class="btn btn-details"><i class="fas fa-eye"></i> Details</a></td>
                                </tr>
                                <tr>
                                    <td>#1002</td>
                                    <td>Bottles, Corks</td>
                                    <td>5,000 units, 5,000 units</td>
                                    <td>2025-07-16</td>
                                    <td><span class="badge badge-status badge-approved">Approved</span></td>
                                    <td><a href="{{ url('/supplier/orders/1002') }}" class="btn btn-details"><i class="fas fa-eye"></i> Details</a></td>
                                </tr>
                                <tr>
                                    <td>#1003</td>
                                    <td>Oak Barrels</td>
                                    <td>50 units</td>
                                    <td>2025-07-17</td>
                                    <td><span class="badge badge-status badge-shipped">Shipped</span></td>
                                    <td><a href="{{ url('/supplier/orders/1003') }}" class="btn btn-details"><i class="fas fa-eye"></i> Details</a></td>
                                </tr>
                                <tr>
                                    <td>#1004</td>
                                    <td>Labels, Capsules</td>
                                    <td>2,000 units, 2,000 units</td>
                                    <td>2025-07-17</td>
                                    <td><span class="badge badge-status badge-delivered">Delivered</span></td>
                                    <td><a href="{{ url('/supplier/orders/1004') }}" class="btn btn-details"><i class="fas fa-eye"></i> Details</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 