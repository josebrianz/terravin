@extends('layouts.app')

@section('title', 'Analytics Dashboard - Terravin Wine Supply Management')

@section('content')
<style>
    :root {
        --burgundy: #5e0f0f;
        --gold: #c8a97e;
        --cream: #f5f0e6;
        --dark-text: #2a2a2a;
        --light-text: #f8f8f8;
        --success-green: #28a745;
        --warning-orange: #ffc107;
        --danger-red: #dc3545;
        --info-blue: #17a2b8;
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
        box-shadow: 0 4px 12px rgba(94, 15, 15, 0.1);
        border: 1px solid var(--gold);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(94, 15, 15, 0.15);
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
        position: relative;
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
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover, .btn-info:hover, .btn-success:hover, .btn-warning:hover {
        background: var(--gold) !important;
        color: var(--burgundy) !important;
        transform: translateY(-1px);
    }
    
    /* KPI Cards */
    .kpi-card {
        background: linear-gradient(135deg, var(--cream) 0%, #faf8f3 100%);
        border-left: 4px solid var(--gold);
    }
    
    .kpi-card .kpi-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }
    
    .kpi-card .kpi-value {
        font-size: 2.5rem;
        font-weight: bold;
        color: var(--burgundy);
        margin-bottom: 0.5rem;
    }
    
    .kpi-card .kpi-label {
        color: var(--dark-text);
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .kpi-card .kpi-subtitle {
        color: #6c757d;
        font-size: 0.875rem;
    }
    
    /* Prediction Form */
    .prediction-form-group label {
        color: var(--burgundy);
        font-weight: bold;
        margin-bottom: 0.5rem;
    }
    
    .prediction-form-group .form-control {
        border: 2px solid var(--gold);
        border-radius: 8px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    
    .prediction-form-group .form-control:focus {
        border-color: var(--burgundy);
        box-shadow: 0 0 0 0.2rem rgba(94, 15, 15, 0.25);
    }
    
    .prediction-result-box {
        background: linear-gradient(135deg, var(--gold) 0%, #d4b88a 100%);
        color: var(--burgundy);
        border: 2px solid var(--burgundy);
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 1.5rem;
        box-shadow: 0 4px 12px rgba(94, 15, 15, 0.15);
        position: relative;
        overflow: hidden;
    }
    
    .prediction-result-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--burgundy), var(--gold));
    }
    
    .prediction-result-box h3 {
        color: var(--burgundy);
        margin-bottom: 1rem;
        font-weight: bold;
    }
    
    .prediction-result-box strong {
        color: var(--burgundy);
    }
    
    /* Alerts */
    .alert {
        border-radius: 8px;
        border: none;
        font-weight: 500;
    }
    
    .alert-success {
        background: linear-gradient(135deg, var(--success-green) 0%, #20c997 100%);
        color: white;
    }
    
    .alert-danger {
        background: linear-gradient(135deg, var(--danger-red) 0%, #e74c3c 100%);
        color: white;
    }
    
    .alert-warning {
        background: linear-gradient(135deg, var(--warning-orange) 0%, #fd7e14 100%);
        color: var(--dark-text);
    }
    
    /* Loading States */
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(245, 240, 230, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        border-radius: 12px;
    }
    
    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid var(--gold);
        border-top: 4px solid var(--burgundy);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* Year Filter */
    .year-filter {
        background: var(--cream);
        border: 2px solid var(--gold);
        border-radius: 8px;
        padding: 0.5rem 1rem;
        color: var(--burgundy);
        font-weight: 600;
    }
    
    .year-filter:focus {
        border-color: var(--burgundy);
        box-shadow: 0 0 0 0.2rem rgba(94, 15, 15, 0.25);
    }
    
    /* Footer */
    footer {
        background: linear-gradient(135deg, var(--dark-text) 0%, #343a40 100%);
        color: var(--light-text);
        text-align: center;
        padding: 3rem 2rem;
        margin-top: 4rem;
        border-top: 3px solid var(--gold);
    }
    
    .social-links {
        margin: 1.5rem 0;
    }
    
    .social-links a {
        color: var(--light-text);
        margin: 0 10px;
        font-size: 1.5rem;
        transition: color 0.3s ease, transform 0.3s ease;
    }
    
    .social-links a:hover {
        color: var(--gold);
        transform: scale(1.2);
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .kpi-card .kpi-value {
            font-size: 2rem;
        }
        
        .kpi-card .kpi-icon {
            font-size: 2rem;
        }
        
        .chart-container {
            min-height: 250px !important;
        }
    }
</style>

<div class="container-fluid">
    <!-- Error Display -->
    @if(isset($error))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ $error }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header border-bottom pb-3 mb-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h1 class="page-title mb-1 fw-bold">
                            <i class="fas fa-chart-bar me-3"></i>
                            Analytics Dashboard
                        </h1>
                        <p class="text-muted mb-0">
                            <i class="fas fa-info-circle me-1"></i>
                            Comprehensive business insights and performance analytics
                        </p>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary me-2">
                            <i class="fas fa-clock me-1"></i>
                            Last updated: {{ now()->format('M d, Y H:i') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Year Filter -->
    <div class="row mb-4">
        <div class="col-auto ms-auto">
            <form method="GET" action="{{ route('analytics.dashboard') }}" class="d-flex align-items-center">
                <label for="year" class="me-2 fw-bold text-burgundy">Filter by Year:</label>
                <select name="year" id="year" class="year-filter" onchange="this.form.submit()">
                    @php $currentYear = request('year', now()->year); @endphp
                    @for($y = now()->year; $y >= now()->year - 5; $y--)
                        <option value="{{ $y }}" @if($currentYear == $y) selected @endif>{{ $y }}</option>
                    @endfor
                </select>
            </form>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="row g-4 mb-5">
        <div class="col-lg-3 col-md-6">
            <div class="card kpi-card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="kpi-icon">
                        <i class="fas fa-chart-line text-primary"></i>
                    </div>
                    <div class="kpi-value">{{ number_format($totalSales) }}</div>
                    <div class="kpi-label">Total Sales</div>
                    <div class="kpi-subtitle">Orders placed this year</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card kpi-card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="kpi-icon">
                        <i class="fas fa-users text-success"></i>
                    </div>
                    <div class="kpi-value">{{ number_format($totalCustomers) }}</div>
                    <div class="kpi-label">Customers</div>
                    <div class="kpi-subtitle">Registered customers</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card kpi-card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="kpi-icon">
                        <i class="fas fa-dollar-sign text-info"></i>
                    </div>
                    <div class="kpi-value">${{ number_format($totalRevenue, 2) }}</div>
                    <div class="kpi-label">Revenue</div>
                    <div class="kpi-subtitle">Total revenue this year</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card kpi-card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="kpi-icon">
                        <i class="fas fa-wine-bottle text-warning"></i>
                    </div>
                    <div class="kpi-value">{{ $topProduct ?? 'N/A' }}</div>
                    <div class="kpi-label">Top Product</div>
                    <div class="kpi-subtitle">Best selling item</div>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-5" style="border-color: var(--gold);">

    <!-- Prediction Section -->
    <div class="row g-4 mb-5">
        <div class="col-lg-12">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-magic me-2"></i> 
                        AI-Powered Sales Prediction
                    </h5>
                    <p class="text-muted mb-0 mt-1">
                        <i class="fas fa-robot me-1"></i>
                        Generate future sales forecasts using machine learning
                    </p>
                </div>
                <div class="card-body">
                    <form action="{{ route('predict.sales') }}" method="POST" id="predictionForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-lg-4 mb-3 prediction-form-group">
                                <label for="year" class="form-label">
                                    <i class="fas fa-calendar me-1"></i>Year:
                                </label>
                                <input type="number" id="year" name="year" class="form-control" 
                                       placeholder="e.g., 2025" required value="{{ old('year', now()->year) }}"
                                       min="2020" max="2030">
                                @error('year') 
                                    <div class="text-danger small mt-1">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div> 
                                @enderror
                            </div>
                            <div class="col-md-6 col-lg-4 mb-3 prediction-form-group">
                                <label for="month" class="form-label">
                                    <i class="fas fa-calendar-day me-1"></i>Month:
                                </label>
                                <input type="number" id="month" name="month" class="form-control" 
                                       placeholder="e.g., 7" required value="{{ old('month') }}"
                                       min="1" max="12">
                                @error('month') 
                                    <div class="text-danger small mt-1">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div> 
                                @enderror
                            </div>
                            <div class="col-md-6 col-lg-4 mb-3 prediction-form-group">
                                <label for="supplier" class="form-label">
                                    <i class="fas fa-truck me-1"></i>Supplier:
                                </label>
                                <input type="text" id="supplier" name="supplier" class="form-control" 
                                       placeholder="e.g., REPUBLIC NATIONAL DISTRIBUTING CO" 
                                       required value="{{ old('supplier') }}" maxlength="255">
                                @error('supplier') 
                                    <div class="text-danger small mt-1">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div> 
                                @enderror
                            </div>
                            <div class="col-md-6 col-lg-4 mb-3 prediction-form-group">
                                <label for="item_description" class="form-label">
                                    <i class="fas fa-tag me-1"></i>Item Description:
                                </label>
                                <input type="text" id="item_description" name="item_description" class="form-control" 
                                       placeholder="e.g., BOOTLEG RED - 750ML" 
                                       required value="{{ old('item_description') }}" maxlength="255">
                                @error('item_description') 
                                    <div class="text-danger small mt-1">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div> 
                                @enderror
                            </div>
                            <div class="col-md-6 col-lg-4 mb-3 prediction-form-group">
                                <label for="item_type" class="form-label">
                                    <i class="fas fa-wine-bottle me-1"></i>Item Type:
                                </label>
                                <input type="text" id="item_type" name="item_type" class="form-control" 
                                       placeholder="e.g., WINE" required value="{{ old('item_type') }}" maxlength="100">
                                @error('item_type') 
                                    <div class="text-danger small mt-1">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div> 
                                @enderror
                            </div>
                            <div class="col-md-6 col-lg-4 mb-3 prediction-form-group">
                                <label for="retail_transfers" class="form-label">
                                    <i class="fas fa-store me-1"></i>Retail Transfers:
                                </label>
                                <input type="number" id="retail_transfers" name="retail_transfers" class="form-control" 
                                       step="0.01" required value="{{ old('retail_transfers') }}" min="0">
                                @error('retail_transfers') 
                                    <div class="text-danger small mt-1">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div> 
                                @enderror
                            </div>
                            <div class="col-md-6 col-lg-4 mb-3 prediction-form-group">
                                <label for="warehouse_sales" class="form-label">
                                    <i class="fas fa-warehouse me-1"></i>Warehouse Sales:
                                </label>
                                <input type="number" id="warehouse_sales" name="warehouse_sales" class="form-control" 
                                       step="0.01" required value="{{ old('warehouse_sales') }}" min="0">
                                @error('warehouse_sales') 
                                    <div class="text-danger small mt-1">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div> 
                                @enderror
                            </div>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="submit" class="btn btn-primary btn-lg" id="predictBtn">
                                <i class="fas fa-calculator me-2"></i> 
                                <span id="predictBtnText">Generate Prediction</span>
                                <div class="spinner-border spinner-border-sm ms-2 d-none" id="predictSpinner"></div>
                            </button>
                        </div>
                    </form>

                    <!-- Prediction Result -->
                    @if(isset($predicted_sales))
                        <div class="prediction-result-box">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-chart-line fa-2x me-3"></i>
                                <h3 class="mb-0">Prediction Result</h3>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="lead mb-2">
                                        <strong>Predicted Retail Sales:</strong>
                                    </p>
                                    <h2 class="text-burgundy fw-bold mb-3">
                                        ${{ number_format($predicted_sales, 2) }}
                                    </h2>
                                </div>
                                <div class="col-md-6">
                                    <div class="alert alert-info mb-0">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Note:</strong> This prediction is based on historical data patterns and machine learning algorithms.
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <hr class="my-5" style="border-color: var(--gold);">

    <!-- Analytics Charts Grid -->
    <div class="row row-cols-1 row-cols-lg-2 g-4">
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-area me-2"></i> Sales & Revenue Trends
                    </h5>
                    <p class="text-muted mb-0 mt-1">Monthly performance overview</p>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center position-relative">
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
                        <i class="fas fa-user-friends me-2"></i> Customer Segments
                    </h5>
                    <p class="text-muted mb-0 mt-1">Distribution by customer type</p>
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
                        <i class="fas fa-wine-bottle me-2"></i> Top 5 Products
                    </h5>
                    <p class="text-muted mb-0 mt-1">Best performing products</p>
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
                        <i class="fas fa-calendar-alt me-2"></i> Monthly Orders
                    </h5>
                    <p class="text-muted mb-0 mt-1">Order volume by month</p>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div class="chart-container w-100" style="min-height: 320px;">
                        <canvas id="monthlyOrdersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer>
    <div class="container">
        <h3 class="mb-3">
            <i class="fas fa-wine-bottle me-2"></i>
            Terravin Wine Estate
        </h3>
        <p class="mb-2">
            <i class="fas fa-map-marker-alt me-2"></i>
            Plot 42 Lakeside Drive • Entebbe, Uganda
        </p>
        <div class="social-links">
            <a href="#" title="Business Hours"><i class="fas fa-clock"></i></a>
            <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" title="Facebook"><i class="fab fa-facebook"></i></a>
            <a href="#" title="Location"><i class="fas fa-map-pin"></i></a>
        </div>
        <p class="mb-0">
            <i class="fas fa-copyright me-1"></i>
            2025 Terravin Wines. All rights reserved.
        </p>
    </div>
</footer>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Form submission with loading state
    document.getElementById('predictionForm').addEventListener('submit', function() {
        const btn = document.getElementById('predictBtn');
        const btnText = document.getElementById('predictBtnText');
        const spinner = document.getElementById('predictSpinner');
        
        btn.disabled = true;
        btnText.textContent = 'Generating Prediction...';
        spinner.classList.remove('d-none');
    });

    // Enhanced chart interactions
    function showDetailModal(title, content) {
        // Create a simple modal for better UX
        const modal = document.createElement('div');
        modal.className = 'modal fade';
        modal.innerHTML = `
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">${title}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>${content}</p>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
        const modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();
        modal.addEventListener('hidden.bs.modal', () => modal.remove());
    }

    // Sales & Revenue Chart
    const salesRevenueCtx = document.getElementById('salesRevenueChart').getContext('2d');
    const salesRevenueChart = new Chart(salesRevenueCtx, {
        type: 'line',
        data: {
            labels: @json($salesRevenueData['labels']),
            datasets: [
                {
                    label: 'Sales (Orders)',
                    data: @json($salesRevenueData['sales']),
                    borderColor: '#5e0f0f',
                    backgroundColor: 'rgba(94, 15, 15, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3
                },
                {
                    label: 'Revenue ($)',
                    data: @json($salesRevenueData['revenue']),
                    borderColor: '#c8a97e',
                    backgroundColor: 'rgba(200, 169, 126, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { 
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(94, 15, 15, 0.9)',
                    titleColor: '#f5f0e6',
                    bodyColor: '#f5f0e6',
                    borderColor: '#c8a97e',
                    borderWidth: 1,
                    callbacks: {
                        label: function(context) {
                            if(context.dataset.label === 'Revenue ($)') {
                                return context.dataset.label + ': $' + context.parsed.y.toLocaleString();
                            }
                            return context.dataset.label + ': ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(200, 169, 126, 0.2)'
                    },
                    ticks: {
                        color: '#5e0f0f'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(200, 169, 126, 0.2)'
                    },
                    ticks: {
                        color: '#5e0f0f'
                    }
                }
            },
            onClick: function(evt, elements) {
                if(elements.length > 0) {
                    const idx = elements[0].index;
                    const label = this.data.labels[idx];
                    const sales = this.data.datasets[0].data[idx];
                    const revenue = this.data.datasets[1].data[idx];
                    showDetailModal(
                        'Month: ' + label,
                        `Sales: ${sales} orders<br>Revenue: $${revenue.toLocaleString()}`
                    );
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
                borderColor: '#5e0f0f',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { 
                    display: true,
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(94, 15, 15, 0.9)',
                    titleColor: '#f5f0e6',
                    bodyColor: '#f5f0e6',
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
                    const total = this.data.datasets[0].data.reduce((a, b) => a + b, 0);
                    const percent = ((value / total) * 100).toFixed(1);
                    showDetailModal(
                        'Customer Segment: ' + label,
                        `Count: ${value}<br>Percentage: ${percent}%`
                    );
                }
            }
        }
    });

    // Top 5 Products Chart
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
                borderWidth: 2,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(94, 15, 15, 0.9)',
                    titleColor: '#f5f0e6',
                    bodyColor: '#f5f0e6',
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + ' units';
                        }
                    }
                }
            },
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(200, 169, 126, 0.2)'
                    },
                    ticks: {
                        color: '#5e0f0f'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(200, 169, 126, 0.2)'
                    },
                    ticks: {
                        color: '#5e0f0f',
                        maxRotation: 45
                    }
                }
            },
            onClick: function(evt, elements) {
                if(elements.length > 0) {
                    const idx = elements[0].index;
                    const label = this.data.labels[idx];
                    const value = this.data.datasets[0].data[idx];
                    showDetailModal(
                        'Product: ' + label,
                        `Units Sold: ${value}`
                    );
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
                borderWidth: 2,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(94, 15, 15, 0.9)',
                    titleColor: '#f5f0e6',
                    bodyColor: '#f5f0e6',
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + ' orders';
                        }
                    }
                }
            },
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(200, 169, 126, 0.2)'
                    },
                    ticks: {
                        color: '#5e0f0f'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(200, 169, 126, 0.2)'
                    },
                    ticks: {
                        color: '#5e0f0f'
                    }
                }
            },
            onClick: function(evt, elements) {
                if(elements.length > 0) {
                    const idx = elements[0].index;
                    const label = this.data.labels[idx];
                    const value = this.data.datasets[0].data[idx];
                    showDetailModal(
                        'Month: ' + label,
                        `Orders: ${value}`
                    );
                }
            }
        }
    });
</script>
@endsection