@extends('layouts.admin')

@section('title', 'Wine Supply Procurement Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-wine-bottle me-2 text-gold"></i>
                        Wine Supply Procurement Dashboard
                    </h1>
                    <span class="text-muted small">Overview of all procurement activities and wholesaler performance</span>
                </div>
                <div class="header-actions">
                    <a href="{{ route('help.index') }}" class="btn btn-outline-burgundy shadow-sm me-2" title="Get help and support">
                        <i class="fas fa-question-circle"></i> Help
                    </a>
                    <a href="{{ route('procurement.create') }}" class="btn btn-burgundy shadow-sm" title="Create a new supply order">
                        <i class="fas fa-plus"></i> New Supply Order
                    </a>
                    <span class="badge bg-gold text-burgundy px-3 py-2 ms-3">
                        <i class="fas fa-clock me-1"></i>
                        {{ now()->format('M d, Y H:i') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Metrics Cards -->
    <div class="row mb-4 g-3">
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="icon-circle bg-burgundy mb-3">
                        <i class="fas fa-wine-bottle fa-2x text-gold"></i>
                    </div>
                    <h4 class="mb-0 fw-bold text-burgundy" title="Total number of supply orders">{{ $totalProcurements }}</h4>
                    <span class="text-muted small">Total Orders</span>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="icon-circle bg-gold mb-3">
                        <i class="fas fa-clock fa-2x text-burgundy"></i>
                    </div>
                    <h4 class="mb-0 fw-bold text-burgundy" title="Orders awaiting approval">{{ $pendingProcurements }}</h4>
                    <span class="text-muted small">Pending</span>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="icon-circle bg-burgundy mb-3">
                        <i class="fas fa-check-circle fa-2x text-gold"></i>
                    </div>
                    <h4 class="mb-0 fw-bold text-burgundy" title="Approved supply orders">{{ $approvedProcurements }}</h4>
                    <span class="text-muted small">Approved</span>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="icon-circle bg-gold mb-3">
                        <i class="fas fa-truck fa-2x text-burgundy"></i>
                    </div>
                    <h4 class="mb-0 fw-bold text-burgundy" title="Orders currently being processed">{{ $orderedProcurements }}</h4>
                    <span class="text-muted small">On Order</span>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="icon-circle bg-burgundy mb-3">
                        <i class="fas fa-box fa-2x text-gold"></i>
                    </div>
                    <h4 class="mb-0 fw-bold text-burgundy" title="Orders received and completed">{{ $receivedProcurements }}</h4>
                    <span class="text-muted small">Received</span>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="icon-circle bg-gold mb-3">
                        <i class="fas fa-times-circle fa-2x text-burgundy"></i>
                    </div>
                    <h4 class="mb-0 fw-bold text-burgundy" title="Orders that were cancelled">{{ $cancelledProcurements }}</h4>
                    <span class="text-muted small">Cancelled</span>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4 wine-divider">

    <!-- Financial Metrics -->
    <div class="row mb-4 g-3">
        <div class="col-lg-3 col-md-6">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="icon-circle bg-burgundy mb-3">
                        <i class="fas fa-coins fa-2x text-gold"></i>
                    </div>
                    <span class="text-burgundy text-uppercase small fw-bold">Total Value</span>
                    <div class="h4 mb-0 fw-bold text-burgundy">UGX {{ number_format($totalValue, 0) }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="icon-circle bg-gold mb-3">
                        <i class="fas fa-clock fa-2x text-burgundy"></i>
                    </div>
                    <span class="text-burgundy text-uppercase small fw-bold">Pending Value</span>
                    <div class="h4 mb-0 fw-bold text-burgundy">UGX {{ number_format($pendingValue, 0) }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="icon-circle bg-burgundy mb-3">
                        <i class="fas fa-check fa-2x text-gold"></i>
                    </div>
                    <span class="text-burgundy text-uppercase small fw-bold">Approved Value</span>
                    <div class="h4 mb-0 fw-bold text-burgundy">UGX {{ number_format($approvedValue, 0) }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="icon-circle bg-gold mb-3">
                        <i class="fas fa-shipping-fast fa-2x text-burgundy"></i>
                    </div>
                    <span class="text-burgundy text-uppercase small fw-bold">On Order Value</span>
                    <div class="h4 mb-0 fw-bold text-burgundy">UGX {{ number_format($orderedValue, 0) }}</div>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4 wine-divider">

    <div class="row g-4">
        <!-- Recent Supply Orders -->
        <div class="col-lg-8">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-history text-gold me-2"></i> Recent Supply Orders
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-burgundy fw-bold">PO Number</th>
                                    <th class="text-burgundy fw-bold">Supply Item</th>
                                    <th class="text-burgundy fw-bold">Wholesaler</th>
                                    <th class="text-burgundy fw-bold">Amount</th>
                                    <th class="text-burgundy fw-bold">Status</th>
                                    <th class="text-burgundy fw-bold">Requested By</th>
                                    <th class="text-burgundy fw-bold">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentProcurements as $procurement)
                                <tr>
                                    <td>
                                        <a href="{{ route('procurement.show', $procurement) }}" class="text-burgundy fw-bold" title="View order details">
                                            {{ $procurement->po_number }}
                                        </a>
                                    </td>
                                    <td>{{ $procurement->item_name }}</td>
                                    <td>{{ $procurement->wholesaler_name }}</td>
                                    <td class="fw-bold">UGX {{ number_format($procurement->amount, 0) }}</td>
                                    <td>
                                        @switch($procurement->status)
                                            @case('pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                                @break
                                            @case('approved')
                                                <span class="badge bg-success">Approved</span>
                                                @break
                                            @case('ordered')
                                                <span class="badge bg-info">On Order</span>
                                                @break
                                            @case('received')
                                                <span class="badge bg-primary">Received</span>
                                                @break
                                            @case('cancelled')
                                                <span class="badge bg-danger">Cancelled</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ ucfirst($procurement->status) }}</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $procurement->requested_by }}</td>
                                    <td>{{ $procurement->created_at->format('M d, Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-3x mb-3 text-muted"></i>
                                        <p class="mb-0">No supply orders found</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('procurement.index') }}" class="btn btn-outline-burgundy" title="View all supply orders">
                            <i class="fas fa-list"></i> View All Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-bolt text-gold me-2"></i> Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('procurement.create') }}" class="btn btn-burgundy shadow-sm">
                            <i class="fas fa-plus me-2"></i> New Supply Order
                        </a>
                        <a href="{{ route('procurement.index') }}" class="btn btn-outline-burgundy">
                            <i class="fas fa-list me-2"></i> All Orders
                        </a>
                        <a href="{{ route('procurement.index', ['status' => 'pending']) }}" class="btn btn-outline-gold">
                            <i class="fas fa-clock me-2"></i> Pending Orders
                        </a>
                        <a href="{{ route('procurement.index', ['status' => 'approved']) }}" class="btn btn-outline-burgundy">
                            <i class="fas fa-check me-2"></i> Approved Orders
                        </a>
                    </div>
                </div>
            </div>

            <!-- Wholesaler Performance -->
            <div class="card wine-card shadow-sm border-0 mt-4">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-chart-line text-gold me-2"></i> Top Wholesalers
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($topWholesalers as $wholesaler)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="mb-0 fw-bold text-burgundy">{{ $wholesaler->wholesaler_name }}</h6>
                            <small class="text-muted">{{ $wholesaler->orders_count }} orders</small>
                        </div>
                        <span class="badge bg-gold text-burgundy">UGX {{ number_format($wholesaler->total_amount, 0) }}</span>
                    </div>
                    @empty
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-chart-bar fa-2x mb-2"></i>
                        <p class="mb-0">No wholesaler data available</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --burgundy: #5e0f0f;
    --gold: #c8a97e;
    --cream: #f5f0e6;
    --light-burgundy: #8b1a1a;
    --dark-gold: #b8945f;
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

.btn-burgundy {
    background-color: var(--burgundy);
    border-color: var(--burgundy);
    color: white;
}

.btn-burgundy:hover {
    background-color: var(--light-burgundy);
    border-color: var(--light-burgundy);
    color: white;
}

.btn-outline-burgundy {
    color: var(--burgundy);
    border-color: var(--burgundy);
}

.btn-outline-burgundy:hover {
    background-color: var(--burgundy);
    border-color: var(--burgundy);
    color: white;
}

.btn-outline-gold {
    color: var(--gold);
    border-color: var(--gold);
}

.btn-outline-gold:hover {
    background-color: var(--gold);
    border-color: var(--gold);
    color: var(--burgundy);
}

.wine-card {
    background: white;
    border-radius: 15px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.wine-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(94, 15, 15, 0.15) !important;
}

.icon-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.wine-divider {
    border-color: var(--gold);
    opacity: 0.3;
}

.page-title {
    color: var(--burgundy);
}

.table th {
    border-color: var(--gold);
    opacity: 0.3;
}

.table td {
    border-color: var(--gold);
    opacity: 0.1;
}

.badge.bg-warning {
    background-color: var(--gold) !important;
    color: var(--burgundy) !important;
}

.badge.bg-success {
    background-color: #28a745 !important;
}

.badge.bg-info {
    background-color: #17a2b8 !important;
}

.badge.bg-primary {
    background-color: var(--burgundy) !important;
}

.badge.bg-danger {
    background-color: #dc3545 !important;
}
</style>
@endsection 