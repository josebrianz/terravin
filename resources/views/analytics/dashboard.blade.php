@extends('layouts.app')

@section('title', 'Analytics Dashboard')

@section('content')
<style>
    :root {
        --burgundy: #5e0f0f;
        --gold: #c8a97e;
        --cream: #f5f0e6;
        --dark-text: #2a2a2a;
        --light-text: #f8f8f8;
    }
    body, .container-fluid {
        background-color: var(--cream) !important;
        color: var(--dark-text) !important;
    }
    .page-header, .card, .card-header, .card-body {
        background: var(--cream) !important;
        color: var(--dark-text) !important;
        border: none;
    }
    .page-title, .card-title, h1, h5, h6 {
        color: var(--burgundy) !important;
        font-family: 'Playfair Display', serif;
    }
    .card {
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(94, 15, 15, 0.08);
        border: 1px solid var(--gold);
    }
    .card .fa-chart-line, .card .fa-users, .card .fa-wine-bottle, .card .fa-dollar-sign {
        color: var(--gold) !important;
        text-shadow: 1px 1px 2px rgba(94, 15, 15, 0.1);
    }
    .card .fa-chart-area, .card .fa-user-friends {
        color: var(--burgundy) !important;
    }
    .chart-container {
        background: var(--burgundy);
        border-radius: 10px;
        padding: 1rem;
    }
    .card-body {
        color: var(--dark-text) !important;
    }
    .btn, .nav-link, .navbar-brand {
        color: var(--burgundy) !important;
    }
    .btn-primary, .btn-info, .btn-success, .btn-warning {
        background: var(--burgundy) !important;
        border-color: var(--gold) !important;
        color: var(--gold) !important;
    }
    .btn-primary:hover, .btn-info:hover, .btn-success:hover, .btn-warning:hover {
        background: var(--gold) !important;
        color: var(--burgundy) !important;
    }
    /* Custom styles for prediction section */
    .prediction-form-group label {
        color: var(--burgundy);
        font-weight: bold;
    }
    .prediction-result-box {
        background-color: var(--gold);
        color: var(--burgundy);
        border: 1px solid var(--burgundy);
        border-radius: 8px;
        padding: 15px;
        margin-top: 20px;
        box-shadow: 0 2px 5px rgba(94, 15, 15, 0.1);
    }
    .prediction-result-box h3 {
        color: var(--burgundy);
        margin-bottom: 10px;
    }
    .prediction-result-box strong {
        color: var(--burgundy);
    }
    footer {
        background-color: var(--dark-text);
        color: var(--light-text);
        text-align: center;
        padding: 3rem 2rem;
    }
    .social-links {
        margin: 1.5rem 0;
    }
    .social-links a {
        color: var(--light-text);
        margin: 0 10px;
        font-size: 1.5rem;
        transition: color 0.3s ease;
    }
    .social-links a:hover {
        color: var(--gold);
    }
</style>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header border-bottom pb-2 mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-title mb-0 fw-bold">
                        <i class="fas fa-chart-bar me-2"></i>
                        Analytics Dashboard
                    </h1>
                    <span class="text-muted small">Business insights and analytics overview</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Year Filter Dropdown -->
    <div class="row mb-3">
        <div class="col-auto ms-auto">
            <form method="GET" action="" class="d-flex align-items-center">
                <label for="year" class="me-2 fw-bold">Year:</label>
                <select name="year" id="year" class="form-select" style="width:auto;" onchange="this.form.submit()">
                    @php $currentYear = request('year', now()->year); @endphp
                    @for($y = now()->year; $y >= now()->year - 5; $y--)
                        <option value="{{ $y }}" @if($currentYear == $y) selected @endif>{{ $y }}</option>
                    @endfor
                </select>
            </form>
        </div>
    </div>

    <!-- Analytics Cards -->
    <div class="row g-4">
        <div class="col-lg-3 col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-chart-line fa-3x text-primary"></i>
                    </div>
                    <h5 class="card-title fw-bold">Total Sales</h5>
                    <p class="display-6 fw-bold">{{ number_format($totalSales) }}</p>
                    <p class="card-text text-muted small">Orders placed</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-users fa-3x text-success"></i>
                    </div>
                    <h5 class="card-title fw-bold">Customers</h5>
                    <p class="display-6 fw-bold">{{ number_format($totalCustomers) }}</p>
                    <p class="card-text text-muted small">Registered customers</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-dollar-sign fa-3x text-info"></i>
                    </div>
                    <h5 class="card-title fw-bold">Revenue</h5>
                    <p class="display-6 fw-bold">${{ number_format($totalRevenue, 2) }}</p>
                    <p class="card-text text-muted small">Total revenue</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-wine-bottle fa-3x text-warning"></i>
                    </div>
                    <h5 class="card-title fw-bold">Top Product</h5>
                    <p class="display-6 fw-bold">{{ $topProduct ?? 'N/A' }}</p>
                    <p class="card-text text-muted small">Best seller</p>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4">

    <!-- Prediction Section -->
    <div class="row g-4 mb-4">
        <div class="col-lg-12">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-magic me-2"></i> Predict Future Retail Sales
                    </h5>
                </div>
                <div class="card-body">
                    {{-- Display success/error messages --}}
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('predict.sales') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-lg-4 mb-3 prediction-form-group">
                                <label for="year" class="form-label">Year:</label>
                                <input type="number" id="year" name="year" class="form-control" placeholder="e.g., 2025" required value="{{ old('year') }}">
                                @error('year') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 col-lg-4 mb-3 prediction-form-group">
                                <label for="month" class="form-label">Month (1-12):</label>
                                <input type="number" id="month" name="month" class="form-control" placeholder="e.g., 7" required value="{{ old('month') }}">
                                @error('month') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 col-lg-4 mb-3 prediction-form-group">
                                <label for="supplier" class="form-label">Supplier:</label>
                                <input type="text" id="supplier" name="supplier" class="form-control" placeholder="e.g., REPUBLIC NATIONAL DISTRIBUTING CO" required value="{{ old('supplier') }}">
                                @error('supplier') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 col-lg-4 mb-3 prediction-form-group">
                                <label for="item_description" class="form-label">Item Description:</label>
                                <input type="text" id="item_description" name="item_description" class="form-control" placeholder="e.g., BOOTLEG RED - 750ML" required value="{{ old('item_description') }}">
                                @error('item_description') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 col-lg-4 mb-3 prediction-form-group">
                                <label for="item_type" class="form-label">Item Type:</label>
                                <input type="text" id="item_type" name="item_type" class="form-control" placeholder="e.g., WINE" required value="{{ old('item_type') }}">
                                @error('item_type') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 col-lg-4 mb-3 prediction-form-group">
                                <label for="retail_transfers" class="form-label">Retail Transfers:</label>
                                <input type="number" id="retail_transfers" name="retail_transfers" class="form-control" step="0.01" required value="{{ old('retail_transfers') }}">
                                @error('retail_transfers') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 col-lg-4 mb-3 prediction-form-group">
                                <label for="warehouse_sales" class="form-label">Warehouse Sales:</label>
                                <input type="number" id="warehouse_sales" name="warehouse_sales" class="form-control" step="0.01" required value="{{ old('warehouse_sales') }}">
                                @error('warehouse_sales') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-calculator me-2"></i> Get Prediction
                            </button>
                        </div>
                    </form>

                    {{-- SECTION TO DISPLAY THE PREDICTED SALES --}}
                    @if(isset($predicted_sales))
                        <div class="prediction-result-box">
                            <h3>Prediction Result:</h3>
                            <p class="lead mb-0">
                                <strong>Predicted Retail Sales:</strong> <span class="fw-bold">${{ number_format($predicted_sales, 2) }}</span>
                            </p>
                            <small class="text-muted">This is an estimated prediction based on your machine learning model.</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4">

    <!-- Organised Analytics Charts Grid -->
    <div class="row row-cols-1 row-cols-lg-2 g-4">
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-area"></i> Sales & Revenue Chart
                    </h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div class="chart-container w-100" style="min-height: 320px;">
                        <canvas id="salesRevenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-user-friends"></i> Customer Segments
                    </h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div class="chart-container w-100" style="min-height: 320px;">
                        <canvas id="customerSegmentsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-wine-bottle"></i> Top 5 Products Sold
                    </h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div class="chart-container w-100" style="min-height: 320px;">
                        <canvas id="topProductsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-calendar-alt"></i> Monthly Orders
                    </h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div class="chart-container w-100" style="min-height: 320px;">
                        <canvas id="monthlyOrdersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add more analytics widgets/charts as needed -->
</div>
<footer>
    <h3>Terravin Wine Estate</h3>
    <p>Plot 42 Lakeside Drive • Entebbe, Uganda</p>
    <div class="social-links">
        <a href="#">⌚</a>
        <a href="#">📸</a>
        <a href="#">👍</a>
        <a href="#">📌</a>
    </div>
    <p>&copy; 2025 Terravin Wines. All rights reserved.</p>
</footer>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Add interactivity: click events and custom tooltips
    function showDetailAlert(label, value, extra) {
        alert(label + ': ' + value + (extra ? ('\n' + extra) : ''));
    }

    // Sales & Revenue Chart
    const salesRevenueCtx = document.getElementById('salesRevenueChart').getContext('2d');
    const salesRevenueChart = new Chart(salesRevenueCtx, {
        type: 'line',
        data: {
            labels: @json($salesRevenueData['labels']),
            datasets: [
                {
                    label: 'Sales',
                    data: @json($salesRevenueData['sales']),
                    borderColor: '#5e0f0f',
                    backgroundColor: 'rgba(94, 15, 15, 0.1)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Revenue',
                    data: @json($salesRevenueData['revenue']),
                    borderColor: '#c8a97e',
                    backgroundColor: 'rgba(200, 169, 126, 0.1)',
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            if(context.dataset.label === 'Revenue') {
                                return context.dataset.label + ': $' + context.parsed.y.toLocaleString();
                            }
                            return context.dataset.label + ': ' + context.parsed.y;
                        }
                    }
                }
            },
            onClick: function(evt, elements) {
                if(elements.length > 0) {
                    const idx = elements[0].index;
                    const label = this.data.labels[idx];
                    const sales = this.data.datasets[0].data[idx];
                    const revenue = this.data.datasets[1].data[idx];
                    showDetailAlert('Month: ' + label, 'Sales: ' + sales + '\nRevenue: $' + revenue);
                }
            }
        }
    });

    // Customer Segments Chart
    const customerSegmentsCtx = document.getElementById('customerSegmentsChart').getContext('2d');
    const customerSegmentsChart = new Chart(customerSegmentsCtx, {
        type: 'doughnut',
        data: {
            labels: @json($customerSegmentsData['labels']),
            datasets: [{
                data: @json($customerSegmentsData['data']),
                backgroundColor: ['#5e0f0f', '#c8a97e', '#f5f0e6'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percent = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed + ' (' + percent + '%)';
                        }
                    }
                }
            },
            onClick: function(evt, elements) {
                if(elements.length > 0) {
                    const idx = elements[0].index;
                    const label = this.data.labels[idx];
                    const value = this.data.datasets[0].data[idx];
                    showDetailAlert('Segment: ' + label, value);
                }
            }
        }
    });

    // Top 5 Products Sold Chart
    const topProductsCtx = document.getElementById('topProductsChart').getContext('2d');
    const topProductsChart = new Chart(topProductsCtx, {
        type: 'bar',
        data: {
            labels: @json($topProductsData['labels']),
            datasets: [{
                label: 'Units Sold',
                data: @json($topProductsData['data']),
                backgroundColor: '#c8a97e',
                borderColor: '#5e0f0f',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + ' units';
                        }
                    }
                }
            },
            scales: {
                y: { beginAtZero: true }
            },
            onClick: function(evt, elements) {
                if(elements.length > 0) {
                    const idx = elements[0].index;
                    const label = this.data.labels[idx];
                    const value = this.data.datasets[0].data[idx];
                    showDetailAlert('Product: ' + label, value + ' units sold');
                }
            }
        }
    });

    // Monthly Orders Chart
    const monthlyOrdersCtx = document.getElementById('monthlyOrdersChart').getContext('2d');
    const monthlyOrdersChart = new Chart(monthlyOrdersCtx, {
        type: 'bar',
        data: {
            labels: @json($monthlyOrdersData['labels']),
            datasets: [{
                label: 'Orders',
                data: @json($monthlyOrdersData['data']),
                backgroundColor: '#5e0f0f',
                borderColor: '#c8a97e',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + ' orders';
                        }
                    }
                }
            },
            scales: {
                y: { beginAtZero: true }
            },
            onClick: function(evt, elements) {
                if(elements.length > 0) {
                    const idx = elements[0].index;
                    const label = this.data.labels[idx];
                    const value = this.data.datasets[0].data[idx];
                    showDetailAlert('Month: ' + label, value + ' orders');
                }
            }
        }
    });
</script>
@endsection