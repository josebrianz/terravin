@extends('layouts.app')

@section('title', 'Shopping Cart - Terravin Wine')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-shopping-cart me-2 text-gold"></i>
                        Shopping Cart
                    </h1>
                    <span class="text-muted small">Review your selected wines</span>
                </div>
                <div class="header-actions">
                    <a href="{{ route('orders.catalog') }}" class="btn btn-outline-burgundy me-2">
                        <i class="fas fa-arrow-left"></i> Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(empty($cart))
    <!-- Empty Cart -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <h3 class="text-muted mb-3">Your cart is empty</h3>
                    <p class="text-muted mb-4">Add some wines to your cart to get started.</p>
                    <a href="{{ route('orders.catalog') }}" class="btn btn-burgundy">
                        <i class="fas fa-wine-bottle"></i> Browse Wines
                    </a>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Cart Items -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-list me-2 text-gold"></i> Cart Items ({{ count($cart) }})
                    </h5>
                </div>
                <div class="card-body p-0">
                    @foreach($cart as $inventoryId => $item)
                    <div class="cart-item p-4 border-bottom">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <img src="{{ $item['image'] }}" 
                                     class="img-fluid rounded wine-thumbnail" 
                                     alt="{{ $item['name'] }}"
                                     onerror="this.src='https://via.placeholder.com/100x150/5e0f0f/ffffff?text=Wine'">
                            </div>
                            <div class="col-md-4">
                                <h6 class="fw-bold text-burgundy mb-1">{{ $item['name'] }}</h6>
                                <p class="text-muted small mb-1">{{ $item['sku'] }}</p>
                                <span class="badge bg-light text-dark">{{ $item['category'] }}</span>
                            </div>
                            <div class="col-md-2 text-center">
                                <div class="price-display">
                                    <span class="price-currency">UGX</span>
                                    <span class="price-amount">{{ number_format($item['price']) }}</span>
                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                <span class="quantity-display">{{ $item['quantity'] }}</span>
                            </div>
                            <div class="col-md-2 text-end">
                                <div class="subtotal-display">
                                    <span class="price-currency">UGX</span>
                                    <span class="price-amount">{{ number_format($item['price'] * $item['quantity']) }}</span>
                                </div>
                                <form action="{{ route('orders.remove-from-cart', $inventoryId) }}" method="POST" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-calculator me-2 text-gold"></i> Order Summary
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $subtotal = 0;
                        $totalItems = 0;
                        foreach($cart as $item) {
                            $subtotal += $item['price'] * $item['quantity'];
                            $totalItems += $item['quantity'];
                        }
                    @endphp
                    
                    <div class="summary-item d-flex justify-content-between mb-2">
                        <span class="text-muted">Items ({{ $totalItems }})</span>
                        <span class="fw-bold">UGX {{ number_format($subtotal) }}</span>
                    </div>
                    
                    <div class="summary-item d-flex justify-content-between mb-2">
                        <span class="text-muted">Shipping</span>
                        <span class="fw-bold text-success">Free</span>
                    </div>
                    
                    <hr>
                    
                    <div class="summary-item d-flex justify-content-between mb-3">
                        <span class="fw-bold text-burgundy">Total</span>
                        <span class="fw-bold text-burgundy fs-5">UGX {{ number_format($subtotal) }}</span>
                    </div>
                    
                    <a href="{{ route('orders.checkout') }}" class="btn btn-burgundy w-100">
                        <i class="fas fa-credit-card"></i> Proceed to Checkout
                    </a>
                    
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            <i class="fas fa-shield-alt me-1"></i>
                            Secure checkout powered by Terravin
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
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
    background: linear-gradient(135deg, var(--cream) 0%, #fff 100%);
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(94, 15, 15, 0.1);
}

.text-burgundy {
    color: var(--burgundy) !important;
}

.text-gold {
    color: var(--gold) !important;
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

.wine-thumbnail {
    width: 100%;
    height: 120px;
    object-fit: cover;
    border-radius: 8px;
}

.cart-item {
    transition: background-color 0.2s ease;
}

.cart-item:hover {
    background-color: var(--cream);
}

.price-currency {
    font-size: 0.875rem;
    color: var(--burgundy);
    font-weight: 500;
}

.price-amount {
    font-size: 1.125rem;
    font-weight: bold;
    color: var(--burgundy);
}

.quantity-display {
    font-weight: bold;
    color: var(--burgundy);
    font-size: 1.125rem;
}

.subtotal-display .price-amount {
    font-size: 1.25rem;
}

.summary-item {
    font-size: 0.95rem;
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
    
    .cart-item .row {
        text-align: center;
    }
    
    .cart-item .col-md-2 {
        margin-bottom: 1rem;
    }
}
</style>
@endpush
@endsection 