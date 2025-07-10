@extends('layouts.admin')

@section('title', 'Order Details - Terravin Wine')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-eye me-2 text-gold"></i> Wine Order #{{ $order->id }}
                    </h1>
                    <span class="text-muted small">View detailed information about this wine order</span>
                </div>
                <div class="header-actions">
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-burgundy" title="Back to orders">
                        <i class="fas fa-arrow-left"></i> Back to Orders
                    </a>
                    <span class="badge bg-gold text-burgundy px-3 py-2 ms-3">
                        <i class="fas fa-clock me-1"></i>
                        {{ now()->format('M d, Y H:i') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-user text-gold me-2"></i> Customer Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong class="text-burgundy">Name:</strong> 
                        <span class="text-dark">{{ $order->customer_name }}</span>
                    </div>
                    <div class="mb-3">
                        <strong class="text-burgundy">Email:</strong> 
                        <span class="text-dark">{{ $order->customer_email }}</span>
                    </div>
                    <div class="mb-3">
                        <strong class="text-burgundy">Phone:</strong> 
                        <span class="text-dark">{{ $order->customer_phone }}</span>
                    </div>
                    <div class="mb-3">
                        <strong class="text-burgundy">Shipping Address:</strong> 
                        <span class="text-dark">{{ $order->shipping_address }}</span>
                    </div>
                    <div class="mb-3">
                        <strong class="text-burgundy">Notes:</strong> 
                        <span class="text-dark">{{ $order->notes ?? 'No notes provided' }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-info-circle text-gold me-2"></i> Order Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong class="text-burgundy">Status:</strong> 
                        <span class="badge {{ $order->status_badge }} ms-2">{{ ucfirst($order->status) }}</span>
                    </div>
                    <div class="mb-3">
                        <strong class="text-burgundy">Total Amount:</strong> 
                        <span class="text-dark fw-bold">UGX {{ number_format($order->total_amount, 0) }}</span>
                    </div>
                    <div class="mb-3">
                        <strong class="text-burgundy">Created At:</strong> 
                        <span class="text-dark">{{ $order->created_at->format('M d, Y H:i') }}</span>
                    </div>
                    <div class="mb-3">
                        <strong class="text-burgundy">Updated At:</strong> 
                        <span class="text-dark">{{ $order->updated_at->format('M d, Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-wine-bottle text-gold me-2"></i> Order Items
                    </h5>
                </div>
                <div class="card-body">
                    @if($order->items && count($order->items) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-burgundy fw-bold">Wine Name</th>
                                        <th class="text-burgundy fw-bold">Quantity</th>
                                        <th class="text-burgundy fw-bold">Unit Price</th>
                                        <th class="text-burgundy fw-bold">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr class="wine-list-item">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-wine-bottle text-gold me-2"></i>
                                                <strong class="text-burgundy">{{ $item['wine_name'] }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-burgundy text-gold">{{ $item['quantity'] }}</span>
                                        </td>
                                        <td>
                                            <span class="text-dark">UGX {{ number_format($item['unit_price'], 0) }}</span>
                                        </td>
                                        <td>
                                            <strong class="text-burgundy">UGX {{ number_format($item['quantity'] * $item['unit_price'], 0) }}</strong>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-wine-bottle fa-2x mb-2"></i>
                            <p class="mb-0">No items in this order.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="text-end mt-4">
        <a href="{{ route('orders.edit', $order) }}" class="btn btn-outline-gold me-2" title="Edit order">
            <i class="fas fa-edit"></i> Edit
        </a>
        <form action="{{ route('orders.destroy', $order) }}" method="POST" class="d-inline" 
              onsubmit="return confirm('Are you sure you want to delete this order?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger" title="Delete order">
                <i class="fas fa-trash"></i> Delete
            </button>
        </form>
        <a href="{{ route('orders.index') }}" class="btn btn-burgundy ms-2" title="Back to orders">
            <i class="fas fa-list"></i> Back to Orders
        </a>
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