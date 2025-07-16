@extends('layouts.app')

@section('title', 'Vendor Dashboard')

@section('navigation')
    @include('layouts.navigation')
@endsection

@section('content')
<style>
:root {
    --burgundy: #5e0f0f;
    --gold: #c8a97e;
    --cream: #f5f0e6;
    --light-burgundy: #8b1a1a;
    --dark-gold: #b8945f;
}
.vendor-theme-bg {
    background: linear-gradient(120deg, var(--cream) 0%, #fff 60%, #f5e6e6 100%);
    min-height: 100vh;
    font-family: 'Segoe UI', 'Figtree', Arial, sans-serif;
}
.card, .stat-card {
    border-radius: 22px;
    box-shadow: 0 6px 32px rgba(94, 15, 15, 0.13);
    border: none;
    background: #fff7f3;
    margin-bottom: 2rem;
}
.page-header {
    background: linear-gradient(135deg, var(--cream) 0%, #fff 100%);
    border-radius: 16px;
    box-shadow: 0 2px 16px rgba(94, 15, 15, 0.13);
    padding: 2rem 2.5rem 1.5rem 2.5rem;
    margin-bottom: 2rem;
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
.btn, .btn-burgundy, .btn-gold, .btn-outline-burgundy, .btn-outline-gold {
    font-size: 1.15rem !important;
    font-weight: 700 !important;
    border-width: 2px !important;
    border-radius: 10px !important;
    box-shadow: 0 2px 10px rgba(94, 15, 15, 0.13) !important;
    transition: all 0.18s !important;
    outline: none !important;
    padding: 0.6rem 1.5rem !important;
    letter-spacing: 0.03em;
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
    box-shadow: 0 4px 18px rgba(94, 15, 15, 0.18) !important;
    transform: translateY(-2px) scale(1.04);
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
    box-shadow: 0 4px 18px rgba(200, 169, 126, 0.18) !important;
    transform: translateY(-2px) scale(1.04);
}
.btn-outline-burgundy {
    border-color: var(--burgundy) !important;
    color: var(--burgundy) !important;
    background: #fff !important;
}
.btn-outline-burgundy:hover, .btn-outline-burgundy:focus {
    background-color: var(--burgundy) !important;
    color: #fff !important;
    box-shadow: 0 4px 18px rgba(94, 15, 15, 0.18) !important;
    transform: translateY(-2px) scale(1.04);
}
.btn-outline-gold {
    border-color: var(--gold) !important;
    color: var(--gold) !important;
    background: #fff !important;
}
.btn-outline-gold:hover, .btn-outline-gold:focus {
    background-color: var(--gold) !important;
    color: var(--burgundy) !important;
    box-shadow: 0 4px 18px rgba(200, 169, 126, 0.18) !important;
    transform: translateY(-2px) scale(1.04);
}
.vendor-list-item {
    background: #f5f0e6;
    border-left: 4px solid var(--burgundy);
    margin-bottom: 0.5rem;
    padding: 0.85rem 1.2rem;
    border-radius: 10px;
    font-size: 1.08rem;
}
.section-title {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--burgundy);
    margin-bottom: 1rem;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.section-divider {
    border-top: 2px solid var(--gold);
    margin: 2.5rem 0 2rem 0;
}
.card-header.bg-white {
    background: linear-gradient(90deg, #fff7f3 60%, #f5e6e6 100%);
    border-radius: 12px 12px 0 0;
    border-bottom: 2px solid #f5e0d6;
    padding-top: 1.2rem;
    padding-bottom: 1.2rem;
}
</style>
<div class="vendor-theme-bg min-vh-100">
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-header border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h1 class="page-title mb-0 fw-bold text-burgundy">
                            <i class="fas fa-warehouse me-2 text-gold"></i>
                            Vendor Dashboard
                        </h1>
                        <span class="text-muted small">All your vendor operations at a glance</span>
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
        <!-- Orders & Inventory -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm stat-card mb-3">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-bold text-burgundy"><i class="fas fa-shopping-cart text-gold me-2"></i> Orders</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-0">
                            <li class="list-group-item">View, confirm, update, and track orders</li>
                            @forelse($orders as $order)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Order #{{ $order->id }}</span>
                                <span class="badge {{ $order->status === 'confirmed' ? 'bg-success' : ($order->status === 'pending' ? 'bg-info' : 'bg-warning text-dark') }}">{{ ucfirst($order->status) }}</span>
                            </li>
                            @empty
                            <li class="list-group-item text-muted">No recent orders</li>
                            @endforelse
                        </ul>
                        <a href="{{ route('vendor.orders.index', ['vendor' => $vendor]) }}" class="btn btn-burgundy btn-sm mt-2">Manage Orders</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm stat-card mb-3">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-bold text-burgundy"><i class="fas fa-boxes text-gold me-2"></i> Inventory & Demand</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-0">
                            <li class="list-group-item">See buyer needs and demand forecasts</li>
                            @forelse($inventory as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $item->name }}</span>
                                <span class="badge {{ $item->quantity < 10 ? 'bg-warning text-dark' : 'bg-secondary' }}">{{ $item->quantity < 10 ? 'High Demand' : 'Normal' }}</span>
                            </li>
                            @empty
                            <li class="list-group-item text-muted">No inventory data</li>
                            @endforelse
                        </ul>
                        <a href="{{ url('vendor/inventory') }}" class="btn btn-gold btn-sm mt-2">View Inventory</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Logistics & Product Specs -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm stat-card mb-3">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-bold text-burgundy"><i class="fas fa-truck text-gold me-2"></i> Logistics</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-0">
                            <li class="list-group-item">Shipment schedules, addresses, proofs of delivery</li>
                            @forelse($shipments as $shipment)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Shipment #{{ $shipment->id }}</span>
                                <span class="badge {{ $shipment->status === 'delivered' ? 'bg-success' : 'bg-info' }}">{{ ucfirst($shipment->status) }}</span>
                            </li>
                            @empty
                            <li class="list-group-item text-muted">No recent shipments</li>
                            @endforelse
                        </ul>
                        <a href="{{ url('vendor/shipments') }}" class="btn btn-outline-gold btn-sm mt-2">Track Shipments</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm stat-card mb-3">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-bold text-burgundy"><i class="fas fa-certificate text-gold me-2"></i> Product Specs & Compliance</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-0">
                            <li class="list-group-item">Quality standards, compliance requirements</li>
                            @forelse($complianceDocs as $doc)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $doc->name }}</span>
                                <span class="badge {{ $doc->status === 'valid' ? 'bg-success' : 'bg-warning text-dark' }}">{{ ucfirst($doc->status) }}</span>
                            </li>
                            @empty
                            <li class="list-group-item text-muted">No compliance documents</li>
                            @endforelse
                        </ul>
                        <a href="{{ url('vendor/compliance-documents') }}" class="btn btn-outline-burgundy btn-sm mt-2">View Specs</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Finance & Reports -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm stat-card mb-3">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-bold text-burgundy"><i class="fas fa-file-invoice-dollar text-gold me-2"></i> Finance</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-0">
                            <li class="list-group-item">Invoices, payments, credits</li>
                            @forelse($invoices as $invoice)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Invoice #{{ $invoice->id }}</span>
                                <span class="badge bg-warning text-dark">Outstanding</span>
                            </li>
                            @empty
                            <li class="list-group-item text-muted">No outstanding invoices</li>
                            @endforelse
                            @forelse($payments as $payment)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Payment #{{ $payment->id }}</span>
                                <span class="badge bg-success">Received</span>
                            </li>
                            @empty
                            @endforelse
                        </ul>
                        <a href="{{ route('vendor.finance') }}" class="btn btn-burgundy btn-sm mt-2">View Finance</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm stat-card mb-3">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-bold text-burgundy"><i class="fas fa-chart-line text-gold me-2"></i> Reports & Audits</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-0">
                            <li class="list-group-item">Performance scorecards, audit data</li>
                            @forelse($reports as $report)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Report #{{ $report->id }}</span>
                                <span class="badge bg-gold text-burgundy">{{ $report->status ?? 'A+' }}</span>
                            </li>
                            @empty
                            <li class="list-group-item text-muted">No recent reports</li>
                            @endforelse
                        </ul>
                        <a href="{{ route('vendor.reports') }}" class="btn btn-outline-gold btn-sm mt-2">View Reports</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Communication & Contracts -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm stat-card mb-3">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-bold text-burgundy"><i class="fas fa-comments text-gold me-2"></i> Communication</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-0">
                            <li class="list-group-item">Messaging, notifications</li>
                            <li class="list-group-item">New Message: <span class="badge bg-info">{{ count($messages) }}</span></li>
                            <li class="list-group-item">Notifications: <span class="badge bg-gold text-burgundy">{{ count($notifications) }}</span></li>
                        </ul>
                        <a href="{{ route('vendor.messages') }}" class="btn btn-outline-burgundy btn-sm mt-2">Go to Messages</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm stat-card mb-3">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-bold text-burgundy"><i class="fas fa-file-contract text-gold me-2"></i> Contracts</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-0">
                            <li class="list-group-item">View and manage agreements</li>
                            @forelse($contracts as $contract)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Contract #{{ $contract->id }}</span>
                                <span class="badge {{ $contract->status === 'active' ? 'bg-success' : 'bg-warning text-dark' }}">{{ ucfirst($contract->status) }}</span>
                            </li>
                            @empty
                            <li class="list-group-item text-muted">No contracts</li>
                            @endforelse
                        </ul>
                        <a href="{{ route('vendor.contracts') }}" class="btn btn-outline-gold btn-sm mt-2">Manage Contracts</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 