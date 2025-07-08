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

    <!-- Analytics Cards -->
    <div class="row g-4">
        <div class="col-lg-3 col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-chart-line fa-3x text-primary"></i>
                    </div>
                    <h5 class="card-title fw-bold">Sales Trends</h5>
                    <p class="card-text text-muted small">Track sales performance over time.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-users fa-3x text-success"></i>
                    </div>
                    <h5 class="card-title fw-bold">Customer Insights</h5>
                    <p class="card-text text-muted small">Analyze customer demographics and behavior.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-wine-bottle fa-3x text-warning"></i>
                    </div>
                    <h5 class="card-title fw-bold">Product Performance</h5>
                    <p class="card-text text-muted small">See which wines are top sellers.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-dollar-sign fa-3x text-info"></i>
                    </div>
                    <h5 class="card-title fw-bold">Revenue Analysis</h5>
                    <p class="card-text text-muted small">Monitor revenue and profitability.</p>
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

    <!-- Placeholder for Analytics Charts -->
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-area"></i> Sales & Revenue Chart
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="salesRevenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-user-friends"></i> Customer Segments
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="customerSegmentsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add more analytics widgets/charts as needed -->
</div>
@endsection