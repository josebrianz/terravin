@extends('layouts.app')

@section('title', 'Wine Supply Logistics Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header border-bottom pb-2 mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-title mb-0 fw-bold">
                        <i class="fas fa-truck me-2"></i>
                        Wine Supply Logistics Dashboard
                    </h1>
                    <span class="text-muted small">Track deliveries, monitor supplier performance, and manage wine supply chain</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Metrics Cards -->
    <div class="row mb-4 g-3">
        <div class="col-lg-3 col-md-6">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0 fw-bold" title="Total supply orders">{{ $totalProcurements }}</h4>
                            <span class="small">Total Orders</span>
                        </div>
                        <i class="fas fa-shopping-cart fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="card bg-info text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0 fw-bold" title="Orders currently in transit">{{ $orderedProcurements }}</h4>
                            <span class="small">In Transit</span>
                        </div>
                        <i class="fas fa-truck fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0 fw-bold" title="Successfully delivered orders">{{ $receivedProcurements }}</h4>
                            <span class="small">Delivered</span>
                        </div>
                        <i class="fas fa-box fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="card bg-danger text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0 fw-bold" title="Overdue deliveries">{{ $overdueProcurements }}</h4>
                            <span class="small">Overdue</span>
                        </div>
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4">

    <!-- Performance Metrics -->
    <div class="row mb-4 g-3">
        <div class="col-lg-4 col-md-6">
            <div class="card border-left-success shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-success text-uppercase small">On-Time Delivery</span>
                            <div class="h5 mb-0 fw-bold">{{ $onTimePercentage }}%</div>
                            <span class="text-muted small">{{ $onTimeDeliveries }} of {{ $totalDeliveries }} deliveries</span>
                        </div>
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6">
            <div class="card border-left-info shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-info text-uppercase small">Inventory Items</span>
                            <div class="h5 mb-0 fw-bold">{{ $totalInventoryItems }}</div>
                            <span class="text-muted small">Total stock items</span>
                        </div>
                        <i class="fas fa-boxes fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6">
            <div class="card border-left-warning shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-warning text-uppercase small">Low Stock Items</span>
                            <div class="h5 mb-0 fw-bold">{{ $lowStockItems->count() }}</div>
                            <span class="text-muted small">Require attention</span>
                        </div>
                        <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4">

    <div class="row g-4">
        <!-- Recent Logistics Activity -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 fw-bold text-primary">Recent Logistics Activity</h6>
                    <a href="{{ route('procurement.index') }}" class="btn btn-sm btn-outline-primary" title="View all orders">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>PO Number</th>
                                    <th>Supply Item</th>
                                    <th>Supplier</th>
                                    <th>Status</th>
                                    <th>Expected Delivery</th>
                                    <th>Requested By</th>
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
                                    <td>
                                        <span class="badge {{ $procurement->status_badge_class }}">
                                            {{ ucfirst($procurement->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($procurement->expected_delivery)
                                            {{ $procurement->expected_delivery->format('M d, Y') }}
                                        @else
                                            <span class="text-muted">Not set</span>
                                        @endif
                                    </td>
                                    <td>{{ $procurement->requester->name ?? 'N/A' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No recent logistics activity</td>
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
            <!-- Upcoming Deliveries -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-bold text-primary">Upcoming Deliveries</h6>
                </div>
                <div class="card-body">
                    @forelse($upcomingDeliveries as $procurement)
                    <div class="mb-3 p-2 border-start border-3 border-primary bg-light rounded">
                        <h6 class="mb-1 fw-semibold">{{ $procurement->item_name }}</h6>
                        <span class="text-muted small">
                            Expected: {{ $procurement->expected_delivery->format('M d, Y') }}<br>
                            Supplier: {{ $procurement->supplier_name }}<br>
                            PO: {{ $procurement->po_number }}
                        </span>
                    </div>
                    @empty
                    <p class="text-muted">No upcoming deliveries</p>
                    @endforelse
                </div>
            </div>

            <!-- Top Suppliers -->
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-bold text-primary">Top Suppliers</h6>
                </div>
                <div class="card-body">
                    @forelse($topSuppliers as $supplier)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="mb-0 fw-semibold">{{ $supplier->supplier_name }}</h6>
                            <span class="text-muted small">{{ $supplier->order_count }} orders</span>
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
        </div>
    </div>

    <hr class="my-4">

    <!-- Low Stock Alerts -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-bold text-danger">Low Stock Alerts</h6>
                </div>
                <div class="card-body">
                    @if($lowStockItems->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Item Name</th>
                                    <th>Current Stock</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lowStockItems as $item)
                                <tr>
                                    <td class="fw-semibold">{{ $item->item_name }}</td>
                                    <td>
                                        <span class="badge bg-danger">{{ $item->quantity }}</span>
                                    </td>
                                    <td>{{ $item->description ?? 'No description' }}</td>
                                    <td>
                                        <a href="{{ route('inventory.edit', $item) }}" class="btn btn-sm btn-outline-primary" title="Update stock">
                                            <i class="fas fa-edit"></i> Update
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center text-success py-4">
                        <i class="fas fa-check-circle fa-3x mb-3"></i>
                        <h5>All items are well stocked!</h5>
                        <p class="text-muted">No low stock alerts at this time.</p>
                    </div>
                    @endif
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
</style>
@endpush
@endsection 