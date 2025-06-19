@extends('layouts.app')

@section('title', 'Terravin Wine Management Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header border-bottom pb-2 mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-title mb-0 fw-bold">
                        <i class="fas fa-wine-bottle me-2"></i>
                        Terravin Wine Management Dashboard
                    </h1>
                    <span class="text-muted small">Centralized overview of all wine business operations</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Module Cards -->
    <div class="row g-4">
        <!-- Wine Supply Procurement Module -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-wine-bottle fa-3x text-primary"></i>
                    </div>
                    <h5 class="card-title fw-bold">Wine Supply Procurement</h5>
                    <p class="card-text text-muted small">Manage wine production supplies, barrels, bottles, and equipment procurement.</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('procurement.dashboard') }}" class="btn btn-primary shadow-sm" title="Go to procurement dashboard">
                            <i class="fas fa-chart-bar"></i> Dashboard
                        </a>
                        <a href="{{ route('procurement.index') }}" class="btn btn-outline-primary" title="View all supply orders">
                            <i class="fas fa-list"></i> All Orders
                        </a>
                        <a href="{{ route('procurement.create') }}" class="btn btn-outline-success" title="Create a new supply order">
                            <i class="fas fa-plus"></i> New Supply Order
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Wine Inventory Module -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-boxes fa-3x text-success"></i>
                    </div>
                    <h5 class="card-title fw-bold">Wine Inventory Management</h5>
                    <p class="card-text text-muted small">Track wine stock levels, manage inventory, and monitor product availability.</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('inventory.index') }}" class="btn btn-success shadow-sm" title="Go to inventory management">
                            <i class="fas fa-boxes"></i> Inventory
                        </a>
                        <a href="{{ route('inventory.create') }}" class="btn btn-outline-success" title="Add a new wine item">
                            <i class="fas fa-plus"></i> Add Wine Item
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Wine Logistics Module -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-truck fa-3x text-info"></i>
                    </div>
                    <h5 class="card-title fw-bold">Wine Logistics Dashboard</h5>
                    <p class="card-text text-muted small">Monitor wine shipments, track deliveries, and manage logistics operations.</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('logistics.dashboard') }}" class="btn btn-info shadow-sm" title="Go to logistics dashboard">
                            <i class="fas fa-truck"></i> Logistics
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4">

    <!-- Quick Stats -->
    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-line"></i> Key Business Metrics
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-3 text-center">
                            <div class="stat-item">
                                <i class="fas fa-wine-bottle fa-2x text-primary mb-2"></i>
                                <h4 class="text-primary fw-bold">{{ \App\Models\Procurement::count() }}</h4>
                                <span class="text-muted small">Supply Orders</span>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="stat-item">
                                <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                                <h4 class="text-warning fw-bold">{{ \App\Models\Procurement::pending()->count() }}</h4>
                                <span class="text-muted small">Pending Approvals</span>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="stat-item">
                                <i class="fas fa-boxes fa-2x text-success mb-2"></i>
                                <h4 class="text-success fw-bold">{{ \App\Models\Inventory::count() }}</h4>
                                <span class="text-muted small">Wine Items</span>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="stat-item">
                                <i class="fas fa-users fa-2x text-info mb-2"></i>
                                <h4 class="text-info fw-bold">{{ \App\Models\User::count() }}</h4>
                                <span class="text-muted small">System Users</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4">

    <!-- Recent Activity -->
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-history"></i> Recent Supply Orders
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach(\App\Models\Procurement::latest()->take(5)->get() as $procurement)
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0">
                            <div>
                                <h6 class="mb-1 fw-semibold">{{ $procurement->item_name }}</h6>
                                <span class="text-muted small">{{ $procurement->po_number }} - {{ $procurement->supplier_name }}</span>
                            </div>
                            <span class="badge {{ $procurement->status_badge_class }}">
                                {{ ucfirst($procurement->status) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-exclamation-triangle"></i> Low Stock Alerts
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach(\App\Models\Inventory::where('quantity', '<', 10)->take(5)->get() as $inventory)
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0">
                            <div>
                                <h6 class="mb-1 fw-semibold">{{ $inventory->item_name }}</h6>
                                <span class="text-muted small">Current Stock: {{ $inventory->quantity }}</span>
                            </div>
                            <span class="badge bg-danger">Low Stock</span>
                        </div>
                        @endforeach
                        @if(\App\Models\Inventory::where('quantity', '<', 10)->count() == 0)
                        <div class="list-group-item text-center text-muted border-0">
                            <i class="fas fa-check-circle"></i> All wine items are well stocked
                        </div>
                        @endif
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
</style>
@endpush
@endsection 