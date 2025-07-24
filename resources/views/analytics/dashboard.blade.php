@extends('layouts.admin')

@section('title', 'Analytics Dashboard - Terravin Wine Supply Management')

@section('content')

<style>
    :root {
        --burgundy: #7B112C;
        --gold: #C8A97E;
        --cream: #F5F0E6;
        --deep-green: #3C5A14;
        --blush: #E6B7A9;
        --rose: #A26769;
        --tawny: #B5651D;
        --dark-burgundy: #5E0F0F;
        --light-gold: #D4B88A;
        --champagne: #E8E0D0;
        --shadow: 0 8px 32px rgba(123, 17, 44, 0.18);
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
        border-radius: 24px;
        box-shadow: var(--shadow);
        border: 2px solid var(--gold);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        margin-bottom: 2.5rem;
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
        background: var(--cream);
        border-radius: 24px;
        padding: 3.5rem 2.5rem 2.5rem 2.5rem;
        position: relative;
        min-height: 600px !important;
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 2.5rem;
    }
    
    .card-body {
        color: var(--dark-text) !important;
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
            min-height: 340px !important;
            padding: 1.2rem;
        }
        .card-title {
            font-size: 1.4rem;
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

    <!-- Inventory by Stock Line Graph (separate row) -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-line me-2"></i> Inventory by Stock (Line Graph)
                    </h5>
                    <p class="text-muted mb-0 mt-1">Stock levels for each product (line graph)</p>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center position-relative">
                    <div class="chart-container w-100">
                        <canvas id="inventoryStockChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Analytics Charts Grid (Pie, Bar, etc.) -->
    <div class="row row-cols-1 row-cols-lg-2 g-4">
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-layer-group me-2"></i> Inventory by Category
                    </h5>
                    <p class="text-muted mb-0 mt-1">Stock distribution by category</p>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center position-relative">
                    <div class="chart-container w-100">
                        <canvas id="inventoryCategoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-shopping-cart me-2"></i> Orders
                    </h5>
                    <p class="text-muted mb-0 mt-1">Orders per month</p>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center position-relative">
                    <div class="chart-container w-100">
                        <canvas id="ordersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-file-invoice-dollar me-2"></i> Procurement
                    </h5>
                    <p class="text-muted mb-0 mt-1">Procurement per month</p>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center position-relative">
                    <div class="chart-container w-100">
                        <canvas id="procurementChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Helper: Create wine-inspired gradients for Chart.js
    function createWineGradient(ctx, area, colors) {
        const gradient = ctx.createLinearGradient(area.left, area.top, area.right, area.bottom);
        colors.forEach((stop, i) => {
            gradient.addColorStop(i / (colors.length - 1), stop);
        });
        return gradient;
    }

    // Chart.js global options for premium look
    Chart.defaults.font.size = 20;
    Chart.defaults.font.family = 'Playfair Display', 'serif';
    Chart.defaults.plugins.legend.labels.boxWidth = 36;
    Chart.defaults.plugins.legend.labels.boxHeight = 20;
    Chart.defaults.plugins.tooltip.bodyFont.size = 20;
    Chart.defaults.plugins.tooltip.titleFont.size = 24;
    Chart.defaults.plugins.tooltip.backgroundColor = '#fff';
    Chart.defaults.plugins.tooltip.titleColor = '#7B112C';
    Chart.defaults.plugins.tooltip.bodyColor = '#2a2a2a';
    Chart.defaults.plugins.tooltip.borderColor = '#C8A97E';
    Chart.defaults.plugins.tooltip.borderWidth = 2;
    Chart.defaults.plugins.tooltip.cornerRadius = 12;
    Chart.defaults.plugins.tooltip.padding = 18;
    Chart.defaults.plugins.tooltip.displayColors = true;
    Chart.defaults.plugins.tooltip.boxPadding = 10;
    Chart.defaults.plugins.title.display = true;
    Chart.defaults.plugins.title.font = { size: 28, weight: 'bold' };
    Chart.defaults.plugins.title.color = '#7B112C';
    Chart.defaults.plugins.title.align = 'start';
    Chart.defaults.plugins.title.padding = { top: 20, bottom: 20 };
    Chart.defaults.elements.bar.borderRadius = 12;
    Chart.defaults.elements.bar.borderSkipped = false;
    Chart.defaults.elements.point.radius = 9;
    Chart.defaults.elements.point.backgroundColor = '#C8A97E';
    Chart.defaults.elements.point.borderColor = '#7B112C';
    Chart.defaults.elements.point.borderWidth = 4;
    Chart.defaults.layout.padding = 32;

    // Inventory by Stock Chart with improved style
    const inventoryStockCtx = document.getElementById('inventoryStockChart').getContext('2d');
    let inventoryStockChart;
    function renderInventoryStockChart() {
        if (inventoryStockChart) inventoryStockChart.destroy();
        inventoryStockChart = new Chart(inventoryStockCtx, {
            type: 'line',
            data: {
                labels: @json($inventoryStockData['labels'] ?? []),
                datasets: [{
                    label: 'Stock',
                    data: @json($inventoryStockData['data'] ?? []),
                    fill: true,
                    backgroundColor: function(context) {
                        const chart = context.chart;
                        const {ctx, chartArea} = chart;
                        if (!chartArea) return '#C8A97E';
                        // Gradient fill for area under the line
                        return createWineGradient(ctx, chartArea, [
                            'rgba(123, 17, 44, 0.10)', // Burgundy (transparent)
                            'rgba(200, 169, 126, 0.08)', // Gold (transparent)
                            'rgba(245, 240, 230, 0.06)' // Cream (transparent)
                        ]);
                    },
                    borderColor: '#7B112C',
                    borderWidth: 5,
                    pointBackgroundColor: '#C8A97E',
                    pointBorderColor: '#7B112C',
                    pointRadius: 0,
                    pointHoverRadius: 0,
                    pointStyle: 'circle',
                    tension: 0.3,
                    shadowOffsetX: 2,
                    shadowOffsetY: 4,
                    shadowBlur: 12,
                    shadowColor: 'rgba(123, 17, 44, 0.18)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#7B112C',
                        bodyColor: '#2a2a2a',
                    }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { color: '#7B112C', font: { size: 18 } }, grid: { color: '#E8E0D0' } },
                    x: { ticks: { color: '#7B112C', font: { size: 18 } }, grid: { color: '#E8E0D0' } }
                }
            }
        });
    }

    // Inventory by Category Chart with gradient
    const inventoryCategoryCtx = document.getElementById('inventoryCategoryChart').getContext('2d');
    let inventoryCategoryChart;
    function renderInventoryCategoryChart() {
        if (inventoryCategoryChart) inventoryCategoryChart.destroy();
        inventoryCategoryChart = new Chart(inventoryCategoryCtx, {
            type: 'doughnut',
            data: {
                labels: @json($inventoryCategoryData['labels'] ?? []),
                datasets: [{
                    data: @json($inventoryCategoryData['data'] ?? []),
                    backgroundColor: @json($inventoryCategoryData['colors'] ?? []),
                    borderColor: '#fff',
                    borderWidth: 2,
                    hoverOffset: 16,
                    hoverBorderColor: '#C8A97E',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true, position: 'bottom', labels: { color: '#7B112C', font: { size: 20 } } },
                    tooltip: { backgroundColor: '#fff', titleColor: '#7B112C', bodyColor: '#2a2a2a' }
                }
            }
        });
    }

    // Orders Chart with gradient
    const ordersCtx = document.getElementById('ordersChart').getContext('2d');
    let ordersChart;
    function renderOrdersChart() {
        if (ordersChart) ordersChart.destroy();
        ordersChart = new Chart(ordersCtx, {
            type: 'bar',
            data: {
                labels: @json($ordersData['labels'] ?? []),
                datasets: [{
                    label: 'Orders',
                    data: @json($ordersData['data'] ?? []),
                    backgroundColor: function(context) {
                        const chart = context.chart;
                        const {ctx, chartArea} = chart;
                        if (!chartArea) return '#C8A97E';
                        return createWineGradient(ctx, chartArea, [
                            '#C8A97E', '#7B112C', '#F5F0E6'
                        ]);
                    },
                    borderColor: '#7B112C',
                    borderWidth: 2,
                    borderRadius: 0,
                    hoverBackgroundColor: '#7B112C',
                    hoverBorderColor: '#C8A97E',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { backgroundColor: '#fff', titleColor: '#7B112C', bodyColor: '#2a2a2a' }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { color: '#7B112C', font: { size: 18 } }, grid: { color: '#E8E0D0' } },
                    x: { ticks: { color: '#7B112C', font: { size: 18 } }, grid: { color: '#E8E0D0' } }
                }
            }
        });
    }

    // Procurement Chart with gradient
    const procurementCtx = document.getElementById('procurementChart').getContext('2d');
    let procurementChart;
    function renderProcurementChart() {
        if (procurementChart) procurementChart.destroy();
        procurementChart = new Chart(procurementCtx, {
            type: 'bar',
            data: {
                labels: @json($procurementData['labels'] ?? []),
                datasets: [{
                    label: 'Procurement',
                    data: @json($procurementData['data'] ?? []),
                    backgroundColor: function(context) {
                        const chart = context.chart;
                        const {ctx, chartArea} = chart;
                        if (!chartArea) return '#3C5A14';
                        return createWineGradient(ctx, chartArea, [
                            '#3C5A14', '#C8A97E', '#7B112C'
                        ]);
                    },
                    borderColor: '#C8A97E',
                    borderWidth: 2,
                    borderRadius: 0,
                    hoverBackgroundColor: '#7B112C',
                    hoverBorderColor: '#C8A97E',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { backgroundColor: '#fff', titleColor: '#7B112C', bodyColor: '#2a2a2a' }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { color: '#3C5A14', font: { size: 18 } }, grid: { color: '#E8E0D0' } },
                    x: { ticks: { color: '#3C5A14', font: { size: 18 } }, grid: { color: '#E8E0D0' } }
                }
            }
        });
    }

    // Render all charts on load and on resize for gradients
    function renderAllCharts() {
        renderInventoryStockChart();
        renderInventoryCategoryChart();
        renderOrdersChart();
        renderProcurementChart();
    }
    window.addEventListener('resize', renderAllCharts);
    window.addEventListener('DOMContentLoaded', renderAllCharts);
</script>
@endsection