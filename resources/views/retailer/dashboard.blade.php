@extends('layouts.app')

@section('title', 'Retailer Dashboard')

@section('navigation')
    @include('layouts.navigation')
@endsection

@section('content')
<div class="wine-theme-bg min-vh-100">
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-header border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h1 class="page-title mb-0 fw-bold text-burgundy">
                            <i class="fas fa-tachometer-alt me-2 text-gold"></i>
                            Retailer Dashboard
                        </h1>
                        <span class="text-muted small">Overview of your retail operations</span>
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
        <!-- Stat Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm text-center stat-card mb-3">
                    <div class="card-body">
                        <i class="fas fa-shopping-bag fa-2x text-gold mb-2"></i>
                        <h6 class="fw-bold">Pending Orders</h6>
                        <div class="display-6 fw-bold">{{ $pendingOrders }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm text-center stat-card mb-3">
                    <div class="card-body">
                        <i class="fas fa-boxes fa-2x text-burgundy mb-2"></i>
                        <h6 class="fw-bold">Low Inventory</h6>
                        <div class="display-6 fw-bold">{{ $lowInventory }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm text-center stat-card mb-3">
                    <div class="card-body">
                        <i class="fas fa-truck fa-2x text-gold mb-2"></i>
                        <h6 class="fw-bold">Recent Procurements</h6>
                        <div class="display-6 fw-bold">{{ $procurements->count() }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm text-center stat-card mb-3">
                    <div class="card-body">
                        <i class="fas fa-bell fa-2x text-burgundy mb-2"></i>
                        <h6 class="fw-bold">Notifications</h6>
                        <div class="display-6 fw-bold">{{ $notifications }}</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm mb-3">
                    <div class="card-body d-flex flex-wrap gap-3 justify-content-between align-items-center">
                        <a href="{{ route('orders.index') }}" class="btn btn-burgundy btn-lg shadow wine-action-btn"><i class="fas fa-shopping-bag me-2"></i> <span class="fw-bold">View Orders</span></a>
                        <a href="{{ route('inventory.index') }}" class="btn btn-gold btn-lg shadow wine-action-btn"><i class="fas fa-boxes me-2"></i> <span class="fw-bold">Inventory</span></a>
                        <a href="{{ route('procurement.dashboard') }}" class="btn btn-outline-burgundy btn-lg shadow wine-action-btn"><i class="fas fa-truck me-2"></i> <span class="fw-bold">Procurement</span></a>
                        <a href="{{ route('reports.index') }}" class="btn btn-outline-gold btn-lg shadow wine-action-btn"><i class="fas fa-chart-line me-2"></i> <span class="fw-bold">Reports</span></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Recent Orders & Top Products -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-bold text-burgundy"><i class="fas fa-shopping-bag text-gold me-2"></i> Recent Orders</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-0">
                            @forelse($recentOrders as $order)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Order #{{ $order->id }} - {{ $order->customer_name }}</span>
                                <span class="badge bg-info">{{ ucfirst($order->status) }}</span>
                            </li>
                            @empty
                            <li class="list-group-item text-muted">No recent orders</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-bold text-burgundy"><i class="fas fa-boxes text-gold me-2"></i> Top Low Inventory Products</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-0">
                            @forelse($topProducts as $product)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $product->name }}</span>
                                <span class="badge bg-warning text-dark">{{ $product->quantity }} left</span>
                            </li>
                            @empty
                            <li class="list-group-item text-muted">No low inventory products</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Recent Procurements -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-bold text-burgundy"><i class="fas fa-truck text-gold me-2"></i> Recent Procurements</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-0">
                            @forelse($procurements as $procurement)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Procurement #{{ $procurement->id }} - {{ $procurement->status }}</span>
                                <span class="badge bg-secondary">UGX {{ number_format($procurement->total_amount ?? 0) }}</span>
                            </li>
                            @empty
                            <li class="list-group-item text-muted">No recent procurements</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
:root {
    --burgundy: #5e0f0f;
    --gold: #c8a97e;
    --cream: #f5f0e6;
    --light-burgundy: #8b1a1a;
    --dark-gold: #b8945f;
}

body, .wine-theme-bg {
    background: linear-gradient(135deg, var(--cream) 0%, #fff 100%);
    min-height: 100vh;
}

.card, .stat-card {
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(94, 15, 15, 0.08);
    background: #fff;
    border: none;
}

.page-header {
    background: linear-gradient(135deg, var(--cream) 0%, #fff 100%);
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(94, 15, 15, 0.08);
}

.btn-burgundy, .btn-gold, .btn-outline-burgundy, .btn-outline-gold {
    border-radius: 8px;
    font-weight: 600;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 8px rgba(94, 15, 15, 0.06);
    transition: all 0.2s;
}

.list-group-item {
    border: none;
    border-radius: 8px !important;
    margin-bottom: 0.5rem;
    background: var(--cream);
}

.list-group-item:last-child {
    margin-bottom: 0;
}

.card-header {
    background: linear-gradient(135deg, #fff 0%, var(--cream) 100%);
    border-bottom: 2px solid var(--cream);
    border-radius: 16px 16px 0 0;
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

::-webkit-scrollbar-thumb {
    background: var(--gold);
    border-radius: 8px;
}

::-webkit-scrollbar-track {
    background: var(--cream);
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

.wine-action-btn {
    min-width: 200px;
    font-size: 1.15rem;
    border-width: 2px;
    transition: transform 0.15s, box-shadow 0.15s, background 0.15s, color 0.15s;
}
.wine-action-btn:hover, .wine-action-btn:focus {
    transform: translateY(-2px) scale(1.04);
    box-shadow: 0 6px 24px rgba(94, 15, 15, 0.13);
    z-index: 2;
}
.btn-burgundy.wine-action-btn {
    background: var(--burgundy);
    color: #fff;
    border-color: var(--burgundy);
}
.btn-burgundy.wine-action-btn:hover, .btn-burgundy.wine-action-btn:focus {
    background: var(--light-burgundy);
    color: #fff;
    border-color: var(--light-burgundy);
}
.btn-gold.wine-action-btn {
    background: var(--gold);
    color: var(--burgundy);
    border-color: var(--gold);
}
.btn-gold.wine-action-btn:hover, .btn-gold.wine-action-btn:focus {
    background: var(--dark-gold);
    color: var(--burgundy);
    border-color: var(--dark-gold);
}
.btn-outline-burgundy.wine-action-btn {
    color: var(--burgundy);
    border-color: var(--burgundy);
    background: #fff;
}
.btn-outline-burgundy.wine-action-btn:hover, .btn-outline-burgundy.wine-action-btn:focus {
    background: var(--burgundy);
    color: #fff;
    border-color: var(--burgundy);
}
.btn-outline-gold.wine-action-btn {
    color: var(--gold);
    border-color: var(--gold);
    background: #fff;
}
.btn-outline-gold.wine-action-btn:hover, .btn-outline-gold.wine-action-btn:focus {
    background: var(--gold);
    color: var(--burgundy);
    border-color: var(--gold);
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Highlight active nav item
    const currentPath = window.location.pathname;
    document.querySelectorAll('.nav-item').forEach(item => {
        if (item.getAttribute('href') === currentPath) {
            item.classList.add('active');
        }
    });
    
    // Simple animations
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach((card, index) => {
        card.style.transitionDelay = `${index * 0.1}s`;
    });
});
</script>