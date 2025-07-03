@extends('layouts.admin')

@section('title', 'All Orders - Terravin Wine')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-shopping-cart me-2 text-gold"></i>
                        All Wine Orders
                    </h1>
                    <span class="text-muted small">Manage and track all customer wine orders</span>
                </div>
                <div class="header-actions">
                    <a href="{{ route('orders.create') }}" class="btn btn-burgundy shadow-sm" title="Create a new wine order">
                        <i class="fas fa-plus"></i> New Order
                    </a>
                    <span class="badge bg-gold text-burgundy px-3 py-2 ms-3">
                        <i class="fas fa-clock me-1"></i>
                        {{ now()->format('M d, Y H:i') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Orders Table -->
    <div class="card wine-card shadow-sm border-0">
        <div class="card-header bg-white border-bottom-0">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-list text-gold me-2"></i> Order List
                    </h5>
                </div>
                <div class="col-auto">
                    <div class="btn-group" role="group">
                        <a href="{{ route('orders.index') }}" class="btn btn-burgundy btn-sm">All</a>
                        <a href="{{ route('orders.pending') }}" class="btn btn-outline-gold btn-sm">Pending</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-burgundy fw-bold">Order ID</th>
                                <th class="text-burgundy fw-bold">Customer</th>
                                <th class="text-burgundy fw-bold">Items</th>
                                <th class="text-burgundy fw-bold">Total Amount</th>
                                <th class="text-burgundy fw-bold">Status</th>
                                <th class="text-burgundy fw-bold">Date</th>
                                <th class="text-burgundy fw-bold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr class="wine-list-item">
                                <td>
                                    <strong class="text-burgundy">#{{ $order->id }}</strong>
                                </td>
                                <td>
                                    <div>
                                        <strong class="text-burgundy">{{ $order->customer_name }}</strong><br>
                                        <small class="text-muted">{{ $order->customer_email }}</small>
                                    </div>
                                </td>
                                <td>
                                    @if($order->items)
                                        @foreach(json_decode($order->items, true) as $item)
                                            <div class="small text-burgundy">
                                                <i class="fas fa-wine-bottle me-1 text-gold"></i>
                                                {{ $item['wine_name'] }} ({{ $item['quantity'] }})
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="text-muted">No items</span>
                                    @endif
                                </td>
                                <td>
                                    <strong class="text-burgundy">UGX {{ number_format($order->total_amount, 0) }}</strong>
                                </td>
                                <td>
                                    <span class="badge {{ $order->status_badge }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $order->created_at->format('M d, Y H:i') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('orders.show', $order) }}" 
                                           class="btn btn-outline-burgundy" title="View order details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('orders.edit', $order) }}" 
                                           class="btn btn-outline-gold" title="Edit order">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('orders.destroy', $order) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this order?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete order">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="icon-circle bg-burgundy mx-auto mb-3">
                        <i class="fas fa-shopping-cart fa-2x text-gold"></i>
                    </div>
                    <h5 class="text-burgundy fw-bold">No orders found</h5>
                    <p class="text-muted">Start by creating your first wine order.</p>
                    <a href="{{ route('orders.create') }}" class="btn btn-burgundy">
                        <i class="fas fa-plus"></i> Create First Order
                    </a>
                </div>
            @endif
        </div>
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

.wine-list-item {
    transition: background-color 0.2s ease;
    border-radius: 8px;
    margin-bottom: 0.5rem;
}

.wine-list-item:hover {
    background-color: var(--cream);
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