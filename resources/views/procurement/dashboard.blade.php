@extends('layouts.app')

@section('title', 'Wine Supply Procurement Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header border-bottom pb-2 mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-title mb-0 fw-bold">
                        <i class="fas fa-wine-bottle me-2"></i>
                        Wine Supply Procurement Dashboard
                    </h1>
                    <span class="text-muted small">Overview of all procurement activities and supplier performance</span>
                </div>
                <div class="page-options">
                    <a href="{{ route('procurement.create') }}" class="btn btn-primary shadow-sm" title="Create a new supply order">
                        <i class="fas fa-plus"></i> New Supply Order
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Metrics Cards -->
    <div class="row mb-4 g-3">
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0 fw-bold" title="Total number of supply orders">{{ $totalProcurements }}</h4>
                            <span class="small">Total Orders</span>
                        </div>
                        <i class="fas fa-wine-bottle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card bg-warning text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0 fw-bold" title="Orders awaiting approval">{{ $pendingProcurements }}</h4>
                            <span class="small">Pending</span>
                        </div>
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card bg-info text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0 fw-bold" title="Approved supply orders">{{ $approvedProcurements }}</h4>
                            <span class="small">Approved</span>
                        </div>
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0 fw-bold" title="Orders currently being processed">{{ $orderedProcurements }}</h4>
                            <span class="small">On Order</span>
                        </div>
                        <i class="fas fa-truck fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0 fw-bold" title="Orders received and completed">{{ $receivedProcurements }}</h4>
                            <span class="small">Received</span>
                        </div>
                        <i class="fas fa-box fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card bg-danger text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0 fw-bold" title="Orders that were cancelled">{{ $cancelledProcurements }}</h4>
                            <span class="small">Cancelled</span>
                        </div>
                        <i class="fas fa-times-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4">

    <!-- Financial Metrics -->
    <div class="row mb-4 g-3">
        <div class="col-lg-3 col-md-6">
            <div class="card border-left-primary shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-primary text-uppercase small">Total Value</span>
                            <div class="h5 mb-0 fw-bold">${{ number_format($totalValue, 2) }}</div>
                        </div>
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-left-warning shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-warning text-uppercase small">Pending Value</span>
                            <div class="h5 mb-0 fw-bold">${{ number_format($pendingValue, 2) }}</div>
                        </div>
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-left-info shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-info text-uppercase small">Approved Value</span>
                            <div class="h5 mb-0 fw-bold">${{ number_format($approvedValue, 2) }}</div>
                        </div>
                        <i class="fas fa-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-left-success shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-success text-uppercase small">On Order Value</span>
                            <div class="h5 mb-0 fw-bold">${{ number_format($orderedValue, 2) }}</div>
                        </div>
                        <i class="fas fa-shipping-fast fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4">

    <div class="row g-4">
        <!-- Recent Supply Orders -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 fw-bold text-primary">Recent Supply Orders</h6>
                    <a href="{{ route('procurement.index') }}" class="btn btn-sm btn-outline-primary" title="View all supply orders">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>PO Number</th>
                                    <th>Supply Item</th>
                                    <th>Supplier</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Requested By</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentProcurements as $procurement)
                                <tr>
                                    <td>
                                        <a href="{{ route('procurement.show', $procurement) }}" class="text-primary fw-bold" title="View order details">
                                            {{ $procurement->po_number }}
                                        </a>
                                    </td>
                                    <td>{{ $procurement->item_name }}</td>
                                    <td>{{ $procurement->supplier_name }}</td>
                                    <td>${{ number_format($procurement->total_amount, 2) }}</td>
                                    <td>
                                        <span class="badge {{ $procurement->status_badge_class }}">
                                            {{ ucfirst($procurement->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $procurement->requester->name ?? 'N/A' }}</td>
                                    <td>{{ $procurement->created_at->format('M d, Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No supply orders found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Top Suppliers -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-bold text-primary">Top Suppliers</h6>
                </div>
                <div class="card-body">
                    @forelse($topSuppliers as $supplier)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="mb-0 fw-semibold">{{ $supplier->supplier_name }}</h6>
                            <span class="text-muted small">{{ $supplier->count }} orders</span>
                        </div>
                        <div class="text-end">
                            <strong>${{ number_format($supplier->total_value, 2) }}</strong>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted">No supplier data available</p>
                    @endforelse
                </div>
            </div>

            <!-- Overdue Procurements -->
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-bold text-danger">Overdue Deliveries</h6>
                </div>
                <div class="card-body">
                    @forelse($overdueProcurements as $procurement)
                    <div class="mb-3 p-2 border-start border-3 border-danger bg-light rounded">
                        <h6 class="mb-1 fw-semibold">{{ $procurement->item_name }}</h6>
                        <span class="text-muted small">
                            Expected: {{ $procurement->expected_delivery->format('M d, Y') }}<br>
                            Supplier: {{ $procurement->supplier_name }}<br>
                            PO: {{ $procurement->po_number }}
                        </span>
                    </div>
                    @empty
                    <p class="text-muted">No overdue deliveries</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4">

    <!-- Monthly Trend Chart -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-bold text-primary">Monthly Procurement Trend (Last 6 Months)</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Month</th>
                                    <th>Number of Orders</th>
                                    <th>Total Value</th>
                                    <th>Average Order Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($monthlyTrend as $trend)
                                <tr>
                                    <td>{{ date('F', mktime(0, 0, 0, $trend->month, 1)) }}</td>
                                    <td>{{ $trend->count }}</td>
                                    <td>${{ number_format($trend->total_value, 2) }}</td>
                                    <td>${{ $trend->count > 0 ? number_format($trend->total_value / $trend->count, 2) : '0.00' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No trend data available</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}
.page-title {
    margin: 0;
    font-size: 1.7rem;
    font-weight: 700;
}
.table th, .table td {
    vertical-align: middle;
}
hr {
    border-top: 2px solid #e9ecef;
}
.border-left-primary {
    border-left: 4px solid #007bff !important;
}
.border-left-warning {
    border-left: 4px solid #ffc107 !important;
}
.border-left-info {
    border-left: 4px solid #17a2b8 !important;
}
.border-left-success {
    border-left: 4px solid #28a745 !important;
}
.text-gray-300 {
    color: #dee2e6 !important;
}
</style>
@endpush
@endsection 