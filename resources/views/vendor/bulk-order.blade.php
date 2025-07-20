<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk Order | TERRAVIN</title>
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
        .bulk-order-section {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            padding: 2rem 2.5rem;
            margin-bottom: 2rem;
        }
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            color: var(--burgundy);
            font-weight: 600;
            margin-bottom: 1rem;
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
        .info-tip {
            background: var(--light-cream);
            border-left: 4px solid var(--gold);
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            color: var(--burgundy);
        }
    </style>
</head>
<body>
    <!-- Wine-themed top nav bar for vendor -->
    <div class="wine-top-bar">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between" style="min-height: 80px;">
                <div class="d-flex align-items-center gap-3">
                    <a class="wine-brand" href="{{ url('/vendor/dashboard') }}">
                        <i class="fas fa-wine-bottle"></i>
                    </a>
                    <nav class="wine-nav">
                        <ul class="nav-links d-flex align-items-center gap-3 mb-0" style="list-style:none;">
                            <li><a href="{{ url('/vendor/dashboard') }}" class="nav-link"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                            <li><a href="{{ url('/vendor/orders') }}" class="nav-link"><i class="fas fa-shopping-bag"></i> Orders</a></li>
                            <li><a href="{{ url('/vendor/inventory') }}" class="nav-link"><i class="fas fa-boxes"></i> Inventory</a></li>
                            <li><a href="{{ url('/reports') }}" class="nav-link"><i class="fas fa-chart-line"></i> Analytics</a></li>
                            <li><a href="{{ url('/vendor/bulk-order') }}" class="nav-link active"><i class="fas fa-wine-bottle"></i> Bulk Order</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="d-flex align-items-center gap-4">
                    <div class="dropdown">
                        <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="profile-photo-placeholder-large rounded-circle d-flex align-items-center justify-content-center me-2" style="border: 6px solid var(--gold); background: linear-gradient(135deg, var(--burgundy) 0%, #8b1a1a 100%); width: 72px; height: 72px; color: #fff; font-size: 2rem;">
                                <span class="fw-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                            <span class="user-name">{{ Auth::user()->name }} <span class="text-gold" style="font-weight: 500;">(Vendor)</span></span>
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
            <h1 class="page-title mb-4"><i class="fas fa-wine-bottle text-gold me-2"></i>Bulk Order from Company</h1>
            <div class="bulk-order-section">
                <div class="info-tip mb-4">
                    <strong>Tip:</strong> Select multiple products, specify quantities, and review your order summary before submitting. For special requests or assistance, contact <a href="mailto:support@terravin.com" style="color: var(--burgundy); text-decoration: underline;">support@terravin.com</a> or call <b>+1-800-TERRAVIN</b>.
                </div>
                <form id="bulkOrderForm" method="POST" action="{{ url('/vendor/bulk-order') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="products" class="form-label fw-bold text-burgundy">Select Products</label>
                        <select id="products" name="products[]" class="form-select" multiple required>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">
                                    {{ $product->name }} | Category: {{ $product->category ?? 'N/A' }} | Stock: {{ $product->stock }} | Price: ${{ number_format($product->unit_price, 2) }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Hold Ctrl (Windows) or Cmd (Mac) to select multiple products.</small>
                    </div>
                    <div id="quantitiesSection" class="mb-4"></div>
                    <div class="mb-4">
                        <label class="form-label fw-bold text-burgundy">Order Summary</label>
                        <div id="orderSummary" class="p-3 bg-white rounded shadow-sm border"></div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold text-burgundy">Vendor Information</label>
                        <div class="row">
                            <div class="col-md-6 mb-2"><strong>Name:</strong> {{ Auth::user()->name }}</div>
                            <div class="col-md-6 mb-2"><strong>Email:</strong> {{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-burgundy btn-lg w-100 shadow" style="font-size: 1.2rem;">
                        <i class="fas fa-paper-plane me-2"></i>Submit Bulk Order
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const productsSelect = document.getElementById('products');
        const quantitiesSection = document.getElementById('quantitiesSection');
        const orderSummary = document.getElementById('orderSummary');
        let productsData = @json($products);

        function updateQuantities() {
            const selected = Array.from(productsSelect.selectedOptions).map(opt => opt.value);
            let html = '';
            selected.forEach(id => {
                const product = productsData.find(p => p.id == id);
                html += `<div class='mb-3'>
                    <label class='form-label text-burgundy fw-bold'>${product.name} (Max: ${product.stock})</label>
                    <input type='number' name='quantities[${id}]' class='form-control' min='1' max='${product.stock}' value='1' required />
                </div>`;
            });
            quantitiesSection.innerHTML = html;
            updateSummary();
        }
        function updateSummary() {
            let summary = '';
            const selected = Array.from(productsSelect.selectedOptions).map(opt => opt.value);
            let total = 0;
            selected.forEach(id => {
                const product = productsData.find(p => p.id == id);
                const qtyInput = document.querySelector(`[name='quantities[${id}]']`);
                const qty = qtyInput ? qtyInput.value : 0;
                const lineTotal = qty * product.unit_price;
                total += parseFloat(lineTotal);
                summary += `<div><strong>${product.name}</strong>: ${qty} units x $${parseFloat(product.unit_price).toFixed(2)} = <span class='text-gold fw-bold'>$${parseFloat(lineTotal).toFixed(2)}</span></div>`;
            });
            if (summary) {
                summary += `<hr><div class='fw-bold text-burgundy'>Total: <span class='text-gold'>$${total.toFixed(2)}</span></div>`;
            }
            orderSummary.innerHTML = summary || '<span class="text-muted">No products selected.</span>';
        }
        productsSelect.addEventListener('change', updateQuantities);
        quantitiesSection.addEventListener('input', updateSummary);
    </script>
</body>
</html> 