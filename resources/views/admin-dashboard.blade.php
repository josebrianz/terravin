@extends('layouts.admin')
e
@section('title', 'Terravin Wine Management Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-wine-bottle me-2 text-gold"></i>
                        Terravin Wine Management Dashboard
                    </h1>
                    <span class="text-muted small">Centralized overview of all wine business operations</span>
                </div>
                <div class="header-actions">
                    @if(auth()->user()->role === 'Wholesaler' || auth()->user()->role === 'Customer')
                        <a href="{{ route('chat.index') }}" class="btn btn-burgundy me-2">
                            <i class="fas fa-comments me-1"></i>
                            Chat
                        </a>
                    @endif
                    <span class="badge bg-gold text-burgundy px-3 py-2">
                        <i class="fas fa-clock me-1"></i>
                        {{ now()->format('M d, Y H:i') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Module Cards -->
    <div class="row g-4">
        <!-- Wine Supply Procurement Module -->
        @if(auth()->user()->role !== 'Customer')
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0 wine-card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="icon-circle bg-burgundy">
                            <i class="fas fa-wine-bottle fa-2x text-gold"></i>
                        </div>
                    </div>
                    <h5 class="card-title fw-bold text-burgundy">Wine Supply Procurement</h5>
                    <p class="card-text text-muted small">Manage wine production supplies, barrels, bottles, and equipment procurement.</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('procurement.dashboard') }}" class="btn btn-burgundy shadow-sm" title="Go to procurement dashboard">
                            <i class="fas fa-chart-bar"></i> Dashboard
                        </a>
                        <a href="{{ route('procurement.index') }}" class="btn btn-outline-burgundy" title="View all supply orders">
                            <i class="fas fa-list"></i> All Orders
                        </a>
                        <a href="{{ route('procurement.create') }}" class="btn btn-outline-gold" title="Create a new supply order">
                            <i class="fas fa-plus"></i> New Supply Order
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!-- Wine Inventory Module -->
        @if(auth()->user()->role !== 'Customer')
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0 wine-card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="icon-circle bg-gold">
                            <i class="fas fa-boxes fa-2x text-burgundy"></i>
                        </div>
                    </div>
                    <h5 class="card-title fw-bold text-burgundy">Wine Inventory Management</h5>
                    <p class="card-text text-muted small">Track wine stock levels, manage inventory, and monitor product availability.</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('inventory.index') }}" class="btn btn-gold shadow-sm" title="Go to inventory management">
                            <i class="fas fa-boxes"></i> Inventory
                        </a>
                        <a href="{{ route('inventory.create') }}" class="btn btn-outline-gold" title="Add a new wine item">
                            <i class="fas fa-plus"></i> Add Wine Item
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!-- Wine Logistics Module -->
        @if(auth()->user()->role !== 'Customer')
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0 wine-card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="icon-circle bg-burgundy">
                            <i class="fas fa-truck fa-2x text-gold"></i>
                        </div>
                    </div>
                    <h5 class="card-title fw-bold text-burgundy">Wine Logistics Dashboard</h5>
                    <p class="card-text text-muted small">Monitor wine shipments, track deliveries, and manage logistics operations.</p>
                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-burgundy shadow-sm disabled" title="Logistics dashboard is disabled" tabindex="-1" aria-disabled="true" style="pointer-events: none; opacity: 0.6;">
                            <i class="fas fa-truck"></i> Logistics
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!-- Order Processing Module -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0 wine-card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="icon-circle bg-gold">
                            <i class="fas fa-shopping-cart fa-2x text-burgundy"></i>
                        </div>
                    </div>
                    <h5 class="card-title fw-bold text-burgundy">Order Processing</h5>
                    <p class="card-text text-muted small">Manage customer orders, track order status, and process wine sales transactions.</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('orders.index') }}" class="btn btn-gold shadow-sm" title="View all orders">
                            <i class="fas fa-list"></i> All Orders
                        </a>
                        <a href="{{ route('orders.pending') }}" class="btn btn-outline-burgundy" title="View pending orders">
                            <i class="fas fa-clock"></i> Pending Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Order Analytics/Reports Module -->
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0 wine-card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="icon-circle bg-gold">
                            <i class="fas fa-chart-line fa-2x text-burgundy"></i>
                        </div>
                    </div>
                    <h5 class="card-title fw-bold text-burgundy">Order Analytics & Reports</h5>
                    <p class="card-text text-muted small">View sales reports, order trends, and export analytics for business insights.</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('reports.index') }}" class="btn btn-burgundy shadow-sm" title="View sales reports">
                            <i class="fas fa-chart-bar"></i> Sales Report
                        </a>
                        <a href="{{ route('orders.index') }}?status=delivered" class="btn btn-outline-gold" title="View delivered orders">
                            <i class="fas fa-truck"></i> Delivered Orders
                        </a>
                        <a href="{{ route('admin.orders.export') }}?format=csv" class="btn btn-outline-secondary" title="Export Order Analytics">
                            <i class="fas fa-file-csv"></i> Export Analytics (CSV)
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Users Management Module -->
        @if(auth()->user()->role === 'Admin')
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0 wine-card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="icon-circle bg-burgundy">
                            <i class="fas fa-users-cog fa-2x text-gold"></i>
                        </div>
                    </div>
                    <h5 class="card-title fw-bold text-burgundy">User Management</h5>
                    <p class="card-text text-muted small">Manage system users, assign roles, and control access.</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.manage-roles') }}" class="btn btn-burgundy shadow-sm" title="Manage user roles">
                            <i class="fas fa-users-cog"></i> Manage Users
                        </a>
                        <a href="{{ route('admin.manage-roles') }}#add-user" class="btn btn-outline-gold" title="Add a new user">
                            <i class="fas fa-user-plus"></i> Add User
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Chat Module (Only for Suppliers and Customers) -->
        @if(auth()->user()->role === 'Wholesaler' || auth()->user()->role === 'Customer')
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0 wine-card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="icon-circle bg-burgundy">
                            <i class="fas fa-comments fa-2x text-gold"></i>
                        </div>
                    </div>
                    <h5 class="card-title fw-bold text-burgundy">Chat System</h5>
                    <p class="card-text text-muted small">Communicate directly with {{ auth()->user()->role === 'Wholesaler' ? 'customers' : 'wholesalers' }} for orders and inquiries.</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('chat.index') }}" class="btn btn-burgundy shadow-sm" title="Start chatting">
                            <i class="fas fa-comments"></i> Start Chat
                        </a>
                        <a href="{{ route('chat.index') }}" class="btn btn-outline-burgundy" title="View all conversations">
                            <i class="fas fa-list"></i> All Conversations
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <hr class="my-4 wine-divider">

    <!-- Quick Stats -->
    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm wine-card">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-chart-line text-gold me-2"></i> Key Business Metrics
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        @if(auth()->user()->role !== 'Customer')
                        <div class="col-md-3 text-center">
                            <div class="stat-item">
                                <div class="stat-icon bg-burgundy">
                                    <i class="fas fa-wine-bottle fa-2x text-gold"></i>
                                </div>
                                <h4 class="text-burgundy fw-bold mt-2">{{ \App\Models\Procurement::count() }}</h4>
                                <span class="text-muted small">Supply Orders</span>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="stat-item">
                                <div class="stat-icon bg-gold">
                                    <i class="fas fa-clock fa-2x text-burgundy"></i>
                                </div>
                                <h4 class="text-burgundy fw-bold mt-2">{{ \App\Models\Procurement::pending()->count() }}</h4>
                                <span class="text-muted small">Pending Approvals</span>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="stat-item">
                                <div class="stat-icon bg-burgundy">
                                    <i class="fas fa-boxes fa-2x text-gold"></i>
                                </div>
                                <h4 class="text-burgundy fw-bold mt-2">{{ \App\Models\Inventory::count() }}</h4>
                                <span class="text-muted small">Wine Items</span>
                            </div>
                        </div>
                        @endif
                        @if(auth()->user()->role === 'Admin')
                        <div class="col-md-3 text-center">
                            <div class="stat-item">
                                <div class="stat-icon bg-gold">
                                    <i class="fas fa-users fa-2x text-burgundy"></i>
                                </div>
                                <h4 class="text-burgundy fw-bold mt-2">{{ \App\Models\User::count() }}</h4>
                                <span class="text-muted small">System Users</span>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="stat-item">
                                <div class="stat-icon bg-warning">
                                    <i class="fas fa-user-check fa-2x text-white"></i>
                                </div>
                                <h4 class="text-burgundy fw-bold mt-2">{{ \App\Models\RoleApprovalRequest::pending()->count() }}</h4>
                                <span class="text-muted small">Role Requests</span>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-3 text-center">
                            <div class="stat-item">
                                <div class="stat-icon bg-burgundy">
                                    <i class="fas fa-shopping-cart fa-2x text-gold"></i>
                                </div>
                                <h4 class="text-burgundy fw-bold mt-2">{{ \App\Models\Order::count() }}</h4>
                                <span class="text-muted small">Total Orders</span>
                            </div>
                        </div>
                        @if(auth()->user()->role === 'Customer')
                        <div class="col-md-3 text-center">
                            <div class="stat-item">
                                <div class="stat-icon bg-gold">
                                    <i class="fas fa-user fa-2x text-burgundy"></i>
                                </div>
                                <h4 class="text-burgundy fw-bold mt-2">{{ \App\Models\Order::where('customer_email', auth()->user()->email)->count() }}</h4>
                                <span class="text-muted small">My Orders</span>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="stat-item">
                                <div class="stat-icon bg-burgundy">
                                    <i class="fas fa-clock fa-2x text-gold"></i>
                                </div>
                                <h4 class="text-burgundy fw-bold mt-2">{{ \App\Models\Order::where('customer_email', auth()->user()->email)->where('status', 'pending')->count() }}</h4>
                                <span class="text-muted small">Pending Orders</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4 wine-divider">

    <!-- Recent Activity -->
    <div class="row g-4">
        @if(auth()->user()->role === 'Admin')
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm wine-card">
                <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-user-check text-gold me-2"></i> Pending Role Requests
                    </h5>
                    <a href="{{ route('admin.role-approvals') }}" class="btn btn-sm btn-outline-burgundy">
                        View All
                    </a>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach(\App\Models\RoleApprovalRequest::with('user')->pending()->latest()->take(5)->get() as $request)
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 wine-list-item">
                            <div>
                                <h6 class="mb-1 fw-semibold text-burgundy">{{ $request->user->name }}</h6>
                                <span class="text-muted small">{{ $request->user->email }} - Requesting {{ $request->requested_role }}</span>
                            </div>
                            <span class="badge bg-warning">Pending</span>
                        </div>
                        @endforeach
                        @if(\App\Models\RoleApprovalRequest::pending()->count() == 0)
                        <div class="list-group-item text-center text-muted border-0 wine-list-item">
                            <i class="fas fa-check-circle text-success"></i> No pending role requests
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(auth()->user()->role !== 'Customer')
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm wine-card">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-history text-gold me-2"></i> Recent Supply Orders
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach(\App\Models\Procurement::latest()->take(5)->get() as $procurement)
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 wine-list-item">
                            <div>
                                <h6 class="mb-1 fw-semibold text-burgundy">{{ $procurement->item_name }}</h6>
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
            <div class="card border-0 shadow-sm wine-card">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-exclamation-triangle text-gold me-2"></i> Low Stock Alerts
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach(\App\Models\Inventory::where('quantity', '<', 10)->take(5)->get() as $inventory)
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 wine-list-item">
                            <div>
                                <h6 class="mb-1 fw-semibold text-burgundy">{{ $inventory->item_name }}</h6>
                                <span class="text-muted small">Current Stock: {{ $inventory->quantity }}</span>
                            </div>
                            <span class="badge bg-danger">Low Stock</span>
                        </div>
                        @endforeach
                        @if(\App\Models\Inventory::where('quantity', '<', 10)->count() == 0)
                        <div class="list-group-item text-center text-muted border-0 wine-list-item">
                            <i class="fas fa-check-circle text-success"></i> All wine items are well stocked
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(auth()->user()->role === 'Customer')
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm wine-card">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-shopping-cart text-gold me-2"></i> My Recent Orders
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach(\App\Models\Order::where('customer_email', auth()->user()->email)->latest()->take(10)->get() as $order)
                        <div class="list-group-item d-flex justify-content-between align-items-center border-0 wine-list-item">
                            <div>
                                <h6 class="mb-1 fw-semibold text-burgundy">{{ $order->wine_name }}</h6>
                                <span class="text-muted small">Order #{{ $order->order_number }} - {{ $order->created_at->format('M d, Y') }}</span>
                            </div>
                            <span class="badge {{ $order->status === 'pending' ? 'bg-warning' : ($order->status === 'completed' ? 'bg-success' : 'bg-info') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        @endforeach
                        @if(\App\Models\Order::where('customer_email', auth()->user()->email)->count() == 0)
                        <div class="list-group-item text-center text-muted border-0 wine-list-item">
                            <i class="fas fa-shopping-cart text-gold"></i> No orders yet.
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
:root {
    --burgundy: #5e0f0f;
    --gold: #c8a97e;
    --cream: #f5f0e6;
    --light-burgundy: #8b1a1a;
    --dark-gold: #b8945f;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, var(--cream) 0%, #fff 100%);
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(94, 15, 15, 0.1);
}

.page-title {
    margin: 0;
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

.btn-gold {
    background-color: var(--gold);
    border-color: var(--gold);
    color: var(--burgundy);
}

.btn-gold:hover {
    background-color: var(--dark-gold);
    border-color: var(--dark-gold);
    color: var(--burgundy);
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
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 12px;
    overflow: hidden;
}

.wine-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(94, 15, 15, 0.15) !important;
}

.icon-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.wine-divider {
    border: none;
    height: 2px;
    background: linear-gradient(90deg, transparent, var(--gold), transparent);
    margin: 2rem 0;
}

.wine-list-item {
    transition: background-color 0.2s ease;
    border-radius: 8px;
    margin-bottom: 0.5rem;
}

.wine-list-item:hover {
    background-color: var(--cream);
}

.stat-item {
    padding: 1rem;
    border-radius: 12px;
    transition: transform 0.2s ease;
}

.stat-item:hover {
    transform: scale(1.05);
}

.header-actions .badge {
    border-radius: 20px;
    font-weight: 500;
}

.card-header {
    border-bottom: 2px solid var(--cream);
    background: linear-gradient(135deg, #fff 0%, var(--cream) 100%);
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .header-actions {
        order: -1;
    }
}
</style>
@endpush
@endsection 