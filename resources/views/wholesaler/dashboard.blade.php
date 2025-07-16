@extends('layouts.app')

@section('title', 'Wholesaler Dashboard')

@section('content')
<div class="wine-theme-bg min-vh-100">
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-header border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h1 class="page-title mb-0 fw-bold text-burgundy">
                            <i class="fas fa-warehouse me-2 text-gold"></i>
                            Wholesaler Dashboard
                        </h1>
                        <span class="text-muted small">Comprehensive overview of your wholesale operations</span>
                    </div>
                    <div class="header-actions">
                        <span class="badge bg-gold text-burgundy px-3 py-2">
                            <i class="fas fa-clock me-1"></i>
                            {{ now()->format('M d, Y H:i') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Inventory & Catalog -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm stat-card mb-3">
                    <div class="card-body text-center">
                        <i class="fas fa-boxes fa-2x text-gold mb-2"></i>
                        <h6 class="fw-bold">Current Stock</h6>
                        <div class="display-6 fw-bold">{{ number_format($stockLevel) }}</div>
                        <a href="{{ route('inventory.index') }}" class="btn btn-outline-burgundy btn-sm mt-2">View Inventory</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm stat-card mb-3">
                    <div class="card-body text-center">
                        <i class="fas fa-list fa-2x text-burgundy mb-2"></i>
                        <h6 class="fw-bold">Product Catalog</h6>
                        <div class="display-6 fw-bold">{{ number_format($catalogCount) }}</div>
                        <a href="{{ route('orders.catalog') }}" class="btn btn-outline-gold btn-sm mt-2">View Catalog</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm stat-card mb-3">
                    <div class="card-body text-center">
                        <i class="fas fa-barcode fa-2x text-gold mb-2"></i>
                        <h6 class="fw-bold">Batch/Lot Tracking</h6>
                        <div class="display-6 fw-bold">{{ number_format($trackedBatches) }}</div>
                        <div class="mt-3 text-start">
                            <ul class="list-group mb-0">
                                @php $latestBatches = \App\Models\Batch::with('product')->latest()->take(3)->get(); @endphp
                                @forelse($latestBatches as $batch)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        <span class="fw-bold">{{ $batch->batch_number }}</span> -
                                        {{ $batch->product->name ?? '-' }}
                                    </span>
                                    <span class="badge bg-gold text-burgundy">{{ $batch->quantity }}</span>
                                    <span class="badge bg-info ms-2">{{ $batch->expiry_date ? $batch->expiry_date->format('M d, Y') : '-' }}</span>
                                </li>
                                @empty
                                <li class="list-group-item text-muted">No recent batches</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Order Management -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-bold text-burgundy"><i class="fas fa-arrow-up text-gold me-2"></i> Orders to Manufacturers</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-0">
                            @forelse($ordersToManufacturers as $order)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Order #{{ $order->id }} - {{ $order->customer_name ?? $order->supplier_name ?? 'N/A' }}</span>
                                <span class="badge bg-info">{{ ucfirst($order->status) }}</span>
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-burgundy ms-2">View</a>
                            </li>
                            @empty
                            <li class="list-group-item text-muted">No outgoing orders</li>
                            @endforelse
                        </ul>
                        <a href="{{ route('orders.index') }}?type=outgoing" class="btn btn-burgundy btn-sm mt-2">View All Outgoing Orders</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-bold text-burgundy"><i class="fas fa-arrow-down text-gold me-2"></i> Orders from Retailers</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-0">
                            @forelse($ordersFromRetailers as $order)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Order #{{ $order->id }} - {{ $order->customer_name ?? $order->retailer_name ?? 'N/A' }}</span>
                                <span class="badge bg-success">{{ ucfirst($order->status) }}</span>
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-gold ms-2">View</a>
                            </li>
                            @empty
                            <li class="list-group-item text-muted">No incoming orders</li>
                            @endforelse
                        </ul>
                        <a href="{{ route('orders.index') }}?type=incoming" class="btn btn-gold btn-sm mt-2">View All Incoming Orders</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pricing & Discounts / Logistics -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-bold text-burgundy"><i class="fas fa-tags text-gold me-2"></i> Pricing & Discounts</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-0">
                            <li class="list-group-item">Bulk Discount: <span class="badge bg-gold text-burgundy">{{ $bulkDiscount }}</span></li>
                            <li class="list-group-item">Promo: <span class="badge bg-info">{{ $promo }}</span></li>
                            <li class="list-group-item">Custom Pricing: <span class="badge bg-secondary">{{ $customPricing }}</span></li>
                        </ul>
                        {{-- <a href="{{ route('pricing.index') }}" class="btn btn-outline-burgundy btn-sm mt-2">Manage Pricing</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-bold text-burgundy"><i class="fas fa-truck text-gold me-2"></i> Logistics & Shipments</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-0">
                            @if($shipmentInTransit)
                            <li class="list-group-item">Shipment #{{ $shipmentInTransit->id }}: <span class="badge bg-info">In Transit</span></li>
                            <li class="list-group-item">Expected Delivery: <span class="badge bg-gold text-burgundy">{{ $expectedDelivery }}</span></li>
                            <li class="list-group-item">Logistics Partner: <span class="badge bg-secondary">{{ $logisticsPartner }}</span></li>
                            @else
                            <li class="list-group-item text-muted">No shipments in transit</li>
                            @endif
                        </ul>
                        <a href="{{ route('logistics.dashboard') }}" class="btn btn-outline-gold btn-sm mt-2">Track Shipments</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Financials & Analytics -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-bold text-burgundy"><i class="fas fa-file-invoice-dollar text-gold me-2"></i> Financial Summary</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-0">
                            <li class="list-group-item">Outstanding Invoices: <span class="badge bg-warning text-dark">UGX {{ number_format($outstandingInvoices) }}</span></li>
                            <li class="list-group-item">Credit Terms: <span class="badge bg-info">{{ $creditTerms }}</span></li>
                            <li class="list-group-item">Last Payment: <span class="badge bg-success">UGX {{ number_format($lastPayment) }}</span></li>
                        </ul>
                        {{-- <a href="{{ route('financial-reports.index') }}" class="btn btn-burgundy btn-sm mt-2">View Financial Reports</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-bold text-burgundy"><i class="fas fa-chart-line text-gold me-2"></i> Analytics & Forecasting</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-3">
                            <li class="list-group-item">Inventory Turnover: <span class="badge bg-info">{{ $inventoryTurnover }}</span></li>
                            <li class="list-group-item">Forecast (next month): <span class="badge bg-secondary">UGX {{ number_format($forecast) }}</span></li>
                        </ul>
                        <div class="mb-2 fw-bold text-burgundy">Sales Trend (last 6 months)</div>
                        <div class="mb-3">
                            <canvas id="salesTrendChart" height="120"></canvas>
                        </div>
                        <a href="#" class="btn btn-gold btn-sm mt-2">View Analytics</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- CRM & Compliance -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-bold text-burgundy"><i class="fas fa-users text-gold me-2"></i> Retailer/Distributor Profiles</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-0">
                            @forelse($retailerProfiles as $retailer)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $retailer->name }}</span>
                                <span class="badge bg-info">Active</span>
                                <a href="#" class="btn btn-sm btn-outline-burgundy ms-2">View</a>
                            </li>
                            @empty
                            <li class="list-group-item text-muted">No retailer profiles</li>
                            @endforelse
                        </ul>
                        <a href="#" class="btn btn-outline-burgundy btn-sm mt-2">Manage Retailers</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-bold text-burgundy"><i class="fas fa-file-alt text-gold me-2"></i> Compliance & Documentation</h6>
                    </div>
                    <div class="card-body">
                        {{-- <a href="{{ route('compliance-documents.index') }}" class="btn btn-outline-gold btn-sm mb-3">Manage Documents</a> --}}
                        <ul class="list-group mb-0">
                            @php $latestDocs = \App\Models\ComplianceDocument::latest()->take(3)->get(); @endphp
                            @forelse($latestDocs as $doc)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    <span class="fw-bold">{{ ucfirst($doc->type) }}</span> -
                                    {{ $doc->name }}
                                </span>
                                <span class="badge {{ $doc->status === 'valid' ? 'bg-success' : 'bg-warning text-dark' }}">{{ ucfirst($doc->status) }}</span>
                                <span class="badge bg-info ms-2">{{ $doc->expiry_date ? $doc->expiry_date->format('M d, Y') : '-' }}</span>
                            </li>
                            @empty
                            <li class="list-group-item text-muted">No recent documents</li>
                            @endforelse
                        </ul>
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
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('salesTrendChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_keys($salesTrends)) !!},
                datasets: [{
                    label: 'Sales (UGX)',
                    data: {!! json_encode(array_values($salesTrends)) !!},
                    borderColor: '#c8a97e',
                    backgroundColor: 'rgba(200, 169, 126, 0.2)',
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#5e0f0f',
                    pointBorderColor: '#5e0f0f',
                }]
            },
            options: {
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) { return 'UGX ' + value.toLocaleString(); }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endsection

<style>
:root {
    --burgundy: #5e0f0f;
    --gold: #c8a97e;
    --cream: #f5f0e6;
    --light-burgundy: #8b1a1a;
    --dark-gold: #b8945f;
    --wine-gradient: linear-gradient(135deg, #f9f6f2 0%, #fffbe6 40%, #e0b96a 100%);
    --wine-card-gradient: linear-gradient(135deg, #fff 0%, #f9f6f2 100%);
}

body, .wine-theme-bg {
    background: var(--wine-gradient);
    min-height: 100vh;
}

.card, .stat-card {
    border-radius: 20px;
    box-shadow: 0 6px 32px rgba(94, 15, 15, 0.12);
    background: var(--wine-card-gradient);
    border: none;
    transition: box-shadow 0.2s, transform 0.2s;
}
.card:hover, .stat-card:hover {
    box-shadow: 0 12px 40px rgba(94, 15, 15, 0.18);
    transform: translateY(-4px) scale(1.02);
}

.page-header {
    background: linear-gradient(135deg, var(--cream) 0%, #fff 100%);
    border-radius: 20px;
    box-shadow: 0 4px 18px rgba(94, 15, 15, 0.10);
    padding: 1.5rem 2rem;
}

.page-title {
    font-size: 2.5rem;
    letter-spacing: 1px;
    color: var(--burgundy);
    text-shadow: 0 2px 8px rgba(200, 169, 106, 0.08);
}

.header-actions .badge {
    border-radius: 20px;
    font-weight: 600;
    font-size: 1.1rem;
    background: var(--gold);
    color: var(--burgundy);
    box-shadow: 0 2px 8px rgba(200, 169, 106, 0.10);
}

.stat-icon-bg {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 0.5rem auto;
    background: linear-gradient(135deg, var(--gold) 0%, var(--burgundy) 100%);
    box-shadow: 0 2px 12px rgba(200, 169, 106, 0.15);
}

.stat-card .display-6 {
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--burgundy);
    text-shadow: 0 2px 8px rgba(200, 169, 106, 0.08);
}

.card-header {
    background: linear-gradient(135deg, #fff 0%, var(--cream) 100%);
    border-bottom: 2px solid var(--cream);
    border-radius: 20px 20px 0 0;
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--burgundy);
}

.text-burgundy {
    color: var(--burgundy) !important;
}
.text-gold {
    color: var(--gold) !important;
}
.bg-burgundy {
    background-color: var(--burgundy) !important;
}
.bg-gold {
    background-color: var(--gold) !important;
}
.bg-cream {
    background-color: var(--cream) !important;
}

.badge {
    font-size: 1rem;
    padding: 0.5em 1em;
    border-radius: 16px;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.list-group-item {
    border: none;
    border-radius: 12px !important;
    margin-bottom: 0.5rem;
    background: var(--cream);
    font-size: 1.08rem;
    transition: background 0.15s;
}
.list-group-item:last-child {
    margin-bottom: 0;
}
.list-group-item:hover {
    background: #fffbe6;
}

.btn, .btn-burgundy, .btn-gold, .btn-outline-burgundy, .btn-outline-gold {
    font-size: 1.1rem !important;
    font-weight: 700 !important;
    border-width: 2px !important;
    border-radius: 8px !important;
    box-shadow: 0 2px 8px rgba(94, 15, 15, 0.10) !important;
    transition: all 0.2s !important;
    outline: none !important;
}
.btn-burgundy {
    background-color: var(--burgundy) !important;
    border-color: var(--burgundy) !important;
    color: #fff !important;
}
.btn-burgundy:hover, .btn-burgundy:focus {
    background-color: var(--light-burgundy) !important;
    border-color: var(--light-burgundy) !important;
    color: #fff !important;
    box-shadow: 0 4px 16px rgba(94, 15, 15, 0.18) !important;
}
.btn-gold {
    background-color: var(--gold) !important;
    border-color: var(--gold) !important;
    color: var(--burgundy) !important;
}
.btn-gold:hover, .btn-gold:focus {
    background-color: var(--dark-gold) !important;
    border-color: var(--dark-gold) !important;
    color: var(--burgundy) !important;
    box-shadow: 0 4px 16px rgba(200, 169, 126, 0.18) !important;
}
.btn-outline-burgundy {
    border-color: var(--burgundy) !important;
    color: var(--burgundy) !important;
    background: #fff !important;
}
.btn-outline-burgundy:hover, .btn-outline-burgundy:focus {
    background-color: var(--burgundy) !important;
    color: #fff !important;
    box-shadow: 0 4px 16px rgba(94, 15, 15, 0.18) !important;
}
.btn-outline-gold {
    border-color: var(--gold) !important;
    color: var(--gold) !important;
    background: #fff !important;
}
.btn-outline-gold:hover, .btn-outline-gold:focus {
    background-color: var(--gold) !important;
    color: var(--burgundy) !important;
    box-shadow: 0 4px 16px rgba(200, 169, 126, 0.18) !important;
}

.section-divider {
    border: none;
    height: 3px;
    background: linear-gradient(90deg, transparent, var(--gold), transparent);
    margin: 2.5rem 0 2rem 0;
    border-radius: 2px;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
        padding: 1rem;
    }
    .header-actions {
        order: -1;
    }
    .stat-card, .card {
        margin-bottom: 1.5rem;
    }
}
</style> 