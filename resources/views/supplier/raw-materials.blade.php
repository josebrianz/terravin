<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raw Materials | Supplier | TERRAVIN</title>
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
        .table thead tr {
            border-radius: var(--border-radius);
        }
        .table-title {
            font-family: 'Playfair Display', serif;
            color: var(--burgundy);
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-align: left;
        }
        .table-desc {
            color: #7b2230;
            font-size: 1rem;
            margin-bottom: 1.2rem;
            text-align: left;
        }
        td, th {
            vertical-align: middle !important;
        }
        .btn-save-wine {
            background: var(--burgundy);
            color: #fff;
            border: 2px solid var(--gold);
            border-radius: 2rem;
            font-weight: 600;
            font-size: 1.08rem;
            padding: 0.6rem 2.2rem;
            box-shadow: 0 2px 8px rgba(94, 15, 15, 0.10);
            transition: background 0.2s, color 0.2s, border 0.2s;
        }
        .btn-save-wine:hover, .btn-save-wine:focus {
            background: var(--light-burgundy);
            color: var(--gold);
            border-color: var(--burgundy);
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
                            <li><a href="{{ url('/supplier/raw-materials') }}" class="nav-link active"><i class="fas fa-cubes"></i> Raw Materials</a></li>
                            <li><a href="{{ url('/supplier/orders') }}" class="nav-link"><i class="fas fa-clipboard-list"></i> Orders</a></li>
                            <li><a href="{{ url('/supplier/reports') }}" class="nav-link"><i class="fas fa-chart-bar"></i> Reports</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="d-flex align-items-center gap-4">
                    <div class="dropdown">
                        <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#" role="button" data-bs-toggle="dropdown">
                            @if(Auth::user()->profile_photo)
                                <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}?v={{ time() }}" alt="{{ Auth::user()->name }}" class="profile-photo-large rounded-circle me-2" style="border: 6px solid var(--gold); width: 72px; height: 72px; object-fit: cover;">
                            @else
                            <div class="profile-photo-placeholder-large rounded-circle d-flex align-items-center justify-content-center me-2" style="border: 6px solid var(--gold); background: linear-gradient(135deg, var(--burgundy) 0%, #8b1a1a 100%); width: 72px; height: 72px; color: #fff; font-size: 2rem;">
                                <span class="fw-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                            @endif
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
            <h1 class="page-title mb-4">Raw Materials in Stock</h1>
            <div class="dashboard-section">
                <div class="section-title"><i class="fas fa-cubes me-2"></i>Manage Raw Materials Inventory</div>
                <div class="table-container">
                    <div class="table-title">Edit Raw Materials</div>
                    <div class="table-desc">Add, edit, or remove raw materials used in your wine production inventory. Click "Add Row" to insert a new material, and "Save" to submit your changes.</div>
                    <form id="raw-materials-form" method="POST" action="#">
                        @csrf
                        <div class="table-responsive">
                            <table class="table align-middle" id="materials-table">
                                <thead>
                                    <tr>
                                        <th>Material Name</th>
                                        <th>Category</th>
                                        <th>Typical Use</th>
                                        <th>Stock Level</th>
                                        <th>Unit Price ($)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
@if(isset($materials) && count($materials) > 0)
    @foreach($materials as $i => $material)
        <tr>
            <td><input type="text" name="materials[{{ $i }}][name]" class="form-control" value="{{ $material->name }}" required></td>
            <td><input type="text" name="materials[{{ $i }}][category]" class="form-control" value="{{ $material->category }}" required></td>
            <td><input type="text" name="materials[{{ $i }}][use]" class="form-control" value="{{ $material->typical_use }}" required></td>
            <td><input type="text" name="materials[{{ $i }}][stock]" class="form-control" value="{{ $material->stock_level }}" required></td>
            <td><input type="number" name="materials[{{ $i }}][unit_price]" class="form-control" value="{{ $material->unit_price }}" min="0" step="0.01" required></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
        </tr>
    @endforeach
@else
    <tr>
        <td><input type="text" name="materials[0][name]" class="form-control" value="Grapes" required></td>
        <td><input type="text" name="materials[0][category]" class="form-control" value="Fruit" required></td>
        <td><input type="text" name="materials[0][use]" class="form-control" value="Main ingredient for wine" required></td>
        <td><input type="text" name="materials[0][stock]" class="form-control" value="5,000 kg" required></td>
        <td><input type="number" name="materials[0][unit_price]" class="form-control" value="2.50" min="0" step="0.01" required></td>
        <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
    </tr>
    <tr>
        <td><input type="text" name="materials[1][name]" class="form-control" value="Yeast" required></td>
        <td><input type="text" name="materials[1][category]" class="form-control" value="Fermentation Agent" required></td>
        <td><input type="text" name="materials[1][use]" class="form-control" value="Converts sugar to alcohol" required></td>
        <td><input type="text" name="materials[1][stock]" class="form-control" value="50 kg" required></td>
        <td><input type="number" name="materials[1][unit_price]" class="form-control" value="8.00" min="0" step="0.01" required></td>
        <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
    </tr>
    <tr>
        <td><input type="text" name="materials[2][name]" class="form-control" value="Oak Barrels" required></td>
        <td><input type="text" name="materials[2][category]" class="form-control" value="Storage" required></td>
        <td><input type="text" name="materials[2][use]" class="form-control" value="Aging and flavoring wine" required></td>
        <td><input type="text" name="materials[2][stock]" class="form-control" value="120 units" required></td>
        <td><input type="number" name="materials[2][unit_price]" class="form-control" value="120.00" min="0" step="0.01" required></td>
        <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
    </tr>
    <tr>
        <td><input type="text" name="materials[3][name]" class="form-control" value="Bottles" required></td>
        <td><input type="text" name="materials[3][category]" class="form-control" value="Packaging" required></td>
        <td><input type="text" name="materials[3][use]" class="form-control" value="Final wine packaging" required></td>
        <td><input type="text" name="materials[3][stock]" class="form-control" value="10,000 units" required></td>
        <td><input type="number" name="materials[3][unit_price]" class="form-control" value="0.30" min="0" step="0.01" required></td>
        <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
    </tr>
    <tr>
        <td><input type="text" name="materials[4][name]" class="form-control" value="Corks" required></td>
        <td><input type="text" name="materials[4][category]" class="form-control" value="Packaging" required></td>
        <td><input type="text" name="materials[4][use]" class="form-control" value="Sealing wine bottles" required></td>
        <td><input type="text" name="materials[4][stock]" class="form-control" value="10,000 units" required></td>
        <td><input type="number" name="materials[4][unit_price]" class="form-control" value="0.15" min="0" step="0.01" required></td>
        <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
    </tr>
    <tr>
        <td><input type="text" name="materials[5][name]" class="form-control" value="Sugar" required></td>
        <td><input type="text" name="materials[5][category]" class="form-control" value="Additive" required></td>
        <td><input type="text" name="materials[5][use]" class="form-control" value="Adjusting sweetness" required></td>
        <td><input type="text" name="materials[5][stock]" class="form-control" value="200 kg" required></td>
        <td><input type="number" name="materials[5][unit_price]" class="form-control" value="0.60" min="0" step="0.01" required></td>
        <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
    </tr>
    <tr>
        <td><input type="text" name="materials[6][name]" class="form-control" value="Sulfites" required></td>
        <td><input type="text" name="materials[6][category]" class="form-control" value="Preservative" required></td>
        <td><input type="text" name="materials[6][use]" class="form-control" value="Preserving wine" required></td>
        <td><input type="text" name="materials[6][stock]" class="form-control" value="30 kg" required></td>
        <td><input type="number" name="materials[6][unit_price]" class="form-control" value="1.20" min="0" step="0.01" required></td>
        <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
    </tr>
    <tr>
        <td><input type="text" name="materials[7][name]" class="form-control" value="Cleaning Agents" required></td>
        <td><input type="text" name="materials[7][category]" class="form-control" value="Sanitation" required></td>
        <td><input type="text" name="materials[7][use]" class="form-control" value="Cleaning equipment" required></td>
        <td><input type="text" name="materials[7][stock]" class="form-control" value="100 L" required></td>
        <td><input type="number" name="materials[7][unit_price]" class="form-control" value="3.00" min="0" step="0.01" required></td>
        <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
    </tr>
    <tr>
        <td><input type="text" name="materials[8][name]" class="form-control" value="Labels" required></td>
        <td><input type="text" name="materials[8][category]" class="form-control" value="Packaging" required></td>
        <td><input type="text" name="materials[8][use]" class="form-control" value="Branding and information" required></td>
        <td><input type="text" name="materials[8][stock]" class="form-control" value="10,000 units" required></td>
        <td><input type="number" name="materials[8][unit_price]" class="form-control" value="0.05" min="0" step="0.01" required></td>
        <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
    </tr>
    <tr>
        <td><input type="text" name="materials[9][name]" class="form-control" value="Bentonite Clay" required></td>
        <td><input type="text" name="materials[9][category]" class="form-control" value="Clarifier" required></td>
        <td><input type="text" name="materials[9][use]" class="form-control" value="Clarifying and stabilizing wine" required></td>
        <td><input type="text" name="materials[9][stock]" class="form-control" value="25 kg" required></td>
        <td><input type="number" name="materials[9][unit_price]" class="form-control" value="1.00" min="0" step="0.01" required></td>
        <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
    </tr>
    <tr>
        <td><input type="text" name="materials[10][name]" class="form-control" value="Enzymes" required></td>
        <td><input type="text" name="materials[10][category]" class="form-control" value="Additive" required></td>
        <td><input type="text" name="materials[10][use]" class="form-control" value="Improving extraction and clarification" required></td>
        <td><input type="text" name="materials[10][stock]" class="form-control" value="10 kg" required></td>
        <td><input type="number" name="materials[10][unit_price]" class="form-control" value="7.00" min="0" step="0.01" required></td>
        <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
    </tr>
    <tr>
        <td><input type="text" name="materials[11][name]" class="form-control" value="Capsules" required></td>
        <td><input type="text" name="materials[11][category]" class="form-control" value="Packaging" required></td>
        <td><input type="text" name="materials[11][use]" class="form-control" value="Sealing bottle tops" required></td>
        <td><input type="text" name="materials[11][stock]" class="form-control" value="10,000 units" required></td>
        <td><input type="number" name="materials[11][unit_price]" class="form-control" value="0.10" min="0" step="0.01" required></td>
        <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
    </tr>
    <tr>
        <td><input type="text" name="materials[12][name]" class="form-control" value="Acids (Tartaric, Malic, Citric)" required></td>
        <td><input type="text" name="materials[12][category]" class="form-control" value="Additive" required></td>
        <td><input type="text" name="materials[12][use]" class="form-control" value="Adjusting acidity" required></td>
        <td><input type="text" name="materials[12][stock]" class="form-control" value="40 kg" required></td>
        <td><input type="number" name="materials[12][unit_price]" class="form-control" value="2.00" min="0" step="0.01" required></td>
        <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
    </tr>
    <tr>
        <td><input type="text" name="materials[13][name]" class="form-control" value="Fining Agents" required></td>
        <td><input type="text" name="materials[13][category]" class="form-control" value="Clarifier" required></td>
        <td><input type="text" name="materials[13][use]" class="form-control" value="Clarifying and stabilizing wine" required></td>
        <td><input type="text" name="materials[13][stock]" class="form-control" value="15 kg" required></td>
        <td><input type="number" name="materials[13][unit_price]" class="form-control" value="1.50" min="0" step="0.01" required></td>
        <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
    </tr>
    <tr>
        <td><input type="text" name="materials[14][name]" class="form-control" value="Tannins" required></td>
        <td><input type="text" name="materials[14][category]" class="form-control" value="Additive" required></td>
        <td><input type="text" name="materials[14][use]" class="form-control" value="Enhancing structure and flavor" required></td>
        <td><input type="text" name="materials[14][stock]" class="form-control" value="8 kg" required></td>
        <td><input type="number" name="materials[14][unit_price]" class="form-control" value="4.00" min="0" step="0.01" required></td>
        <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
    </tr>
    <tr>
        <td><input type="text" name="materials[15][name]" class="form-control" value="Water" required></td>
        <td><input type="text" name="materials[15][category]" class="form-control" value="Base" required></td>
        <td><input type="text" name="materials[15][use]" class="form-control" value="Dilution and cleaning" required></td>
        <td><input type="text" name="materials[15][stock]" class="form-control" value="1,000 L" required></td>
        <td><input type="number" name="materials[15][unit_price]" class="form-control" value="0.01" min="0" step="0.01" required></td>
        <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
    </tr>
    <tr>
        <td><input type="text" name="materials[16][name]" class="form-control" value="Nutrients" required></td>
        <td><input type="text" name="materials[16][category]" class="form-control" value="Additive" required></td>
        <td><input type="text" name="materials[16][use]" class="form-control" value="Supporting yeast health" required></td>
        <td><input type="text" name="materials[16][stock]" class="form-control" value="12 kg" required></td>
        <td><input type="number" name="materials[16][unit_price]" class="form-control" value="2.20" min="0" step="0.01" required></td>
        <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
    </tr>
    <tr>
        <td><input type="text" name="materials[17][name]" class="form-control" value="Filtering Pads" required></td>
        <td><input type="text" name="materials[17][category]" class="form-control" value="Filtration" required></td>
        <td><input type="text" name="materials[17][use]" class="form-control" value="Filtering wine before bottling" required></td>
        <td><input type="text" name="materials[17][stock]" class="form-control" value="200 units" required></td>
        <td><input type="number" name="materials[17][unit_price]" class="form-control" value="0.50" min="0" step="0.01" required></td>
        <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
    </tr>
@endif
                                </tbody>
                            </table>
                        </div>
                        <button type="button" id="add-row" class="btn btn-burgundy" style="margin-top: 1rem;"><i class="fas fa-plus"></i> Add Row</button>
                        <button type="submit" class="btn btn-save-wine" style="margin-top: 1rem; margin-left: 1rem;"><i class="fas fa-save"></i> Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let rowIdx = 18;
        document.getElementById('add-row').addEventListener('click', function() {
            const table = document.getElementById('materials-table').getElementsByTagName('tbody')[0];
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="text" name="materials[${rowIdx}][name]" class="form-control" placeholder="e.g. Grapes" required></td>
                <td><input type="text" name="materials[${rowIdx}][category]" class="form-control" placeholder="e.g. Fruit" required></td>
                <td><input type="text" name="materials[${rowIdx}][use]" class="form-control" placeholder="e.g. Main ingredient" required></td>
                <td><input type="text" name="materials[${rowIdx}][stock]" class="form-control" placeholder="e.g. 5,000 kg" required></td>
                <td><input type="number" name="materials[${rowIdx}][unit_price]" class="form-control" placeholder="e.g. 1.00" min="0" step="0.01" required></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
            `;
            table.appendChild(newRow);
            rowIdx++;
        });
        document.getElementById('materials-table').addEventListener('click', function(e) {
            if (e.target.closest('.remove-row')) {
                const row = e.target.closest('tr');
                if (document.querySelectorAll('#materials-table tbody tr').length > 1) {
                    row.remove();
                }
            }
        });
    </script>
</body>
</html> 