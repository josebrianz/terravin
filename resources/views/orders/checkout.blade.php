@extends('layouts.app')

@section('title', 'Checkout - Terravin Wine')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-credit-card me-2 text-gold"></i>
                        Checkout
                    </h1>
                    <span class="text-muted small">Complete your order</span>
                </div>
                <div class="header-actions">
                    <a href="{{ route('orders.cart') }}" class="btn btn-outline-burgundy">
                        <i class="fas fa-arrow-left"></i> Back to Cart
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Checkout Form -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-user me-2 text-gold"></i> Customer Information
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('orders.place') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customer_name" class="form-label fw-bold text-burgundy">Full Name *</label>
                                <input type="text" class="form-control @error('customer_name') is-invalid @enderror" 
                                       id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="customer_email" class="form-label fw-bold text-burgundy">Email Address *</label>
                                <input type="email" class="form-control @error('customer_email') is-invalid @enderror" 
                                       id="customer_email" name="customer_email" value="{{ old('customer_email') }}" required>
                                @error('customer_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customer_phone" class="form-label fw-bold text-burgundy">Phone Number *</label>
                                <input type="tel" class="form-control @error('customer_phone') is-invalid @enderror" 
                                       id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required>
                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="shipping_address" class="form-label fw-bold text-burgundy">Shipping Address *</label>
                                <textarea class="form-control @error('shipping_address') is-invalid @enderror" 
                                          id="shipping_address" name="shipping_address" rows="3" required>{{ old('shipping_address') }}</textarea>
                                @error('shipping_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label fw-bold text-burgundy">Order Notes (Optional)</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3" placeholder="Any special instructions or requests...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('orders.cart') }}" class="btn btn-outline-burgundy">
                                <i class="fas fa-arrow-left"></i> Back to Cart
                            </a>
                            <button type="submit" class="btn btn-burgundy">
                                <i class="fas fa-check"></i> Place Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-list me-2 text-gold"></i> Order Summary
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
                    
                    <!-- Cart Items Preview -->
                    <div class="cart-preview mb-3">
                        @foreach($cart as $item)
                        <div class="cart-item-preview d-flex align-items-center mb-2">
                            <img src="{{ $item['image'] }}" 
                                 class="wine-thumbnail me-2" 
                                 alt="{{ $item['name'] }}"
                                 onerror="this.src='https://via.placeholder.com/50x75/5e0f0f/ffffff?text=Wine'">
                            <div class="flex-grow-1">
                                <h6 class="mb-0 text-burgundy fw-bold">{{ $item['name'] }}</h6>
                                <small class="text-muted">Qty: {{ $item['quantity'] }}</small>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <hr>
                    
                    <!-- Summary -->
                    <div class="summary-item d-flex justify-content-between mb-2">
                        <span class="text-muted">Items ({{ $totalItems }})</span>
                        <span class="fw-bold">${{ number_format($subtotal, 2) }}</span>
                    </div>
                    
                    <div class="summary-item d-flex justify-content-between mb-2">
                        <span class="text-muted">Shipping</span>
                        <span class="fw-bold text-success">Free</span>
                    </div>
                    
                    <hr>
                    
                    <div class="summary-item d-flex justify-content-between mb-3">
                        <span class="fw-bold text-burgundy fs-5">${{ number_format($subtotal, 2) }}</span>
                        <span class="fw-bold text-burgundy fs-4">${{ number_format($subtotal, 2) }}</span>
                    </div>
                    
                    <!-- Security Notice -->
                    <div class="alert alert-info border-0">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-shield-alt text-info me-2"></i>
                            <div>
                                <small class="fw-bold">Secure Checkout</small><br>
                                <small class="text-muted">Your information is protected</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

.form-control:focus {
    border-color: var(--gold);
    box-shadow: 0 0 0 0.2rem rgba(200, 169, 126, 0.25);
}

.wine-thumbnail {
    width: 50px;
    height: 75px;
    object-fit: cover;
    border-radius: 6px;
}

.cart-item-preview {
    padding: 0.5rem 0;
    border-bottom: 1px solid var(--cream);
}

.cart-item-preview:last-child {
    border-bottom: none;
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
}
</style>
@endpush
@endsection
 