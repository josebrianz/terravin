@extends('layouts.admin')

@section('title', 'Edit Order #' . $order->id)

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-edit me-2 text-gold"></i>
                        Edit Order #{{ $order->id }}
                    </h1>
                    <span class="text-muted small">Update order details and manage customer information</span>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-burgundy me-2">
                        <i class="fas fa-eye me-1"></i>
                        View Order
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-gold">
                        <i class="fas fa-arrow-left me-1"></i>
                        Back to Orders
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 wine-card">
                <div class="card-header bg-burgundy text-white">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-edit me-2"></i>
                        Order Information
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Customer Information -->
                            <div class="col-md-6 mb-3">
                                <label for="customer_name" class="form-label fw-bold text-burgundy">
                                    <i class="fas fa-user me-1"></i>Customer Name
                                </label>
                                <input type="text" 
                                       class="form-control @error('customer_name') is-invalid @enderror" 
                                       id="customer_name" 
                                       name="customer_name" 
                                       value="{{ old('customer_name', $order->customer_name) }}" 
                                       required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="customer_email" class="form-label fw-bold text-burgundy">
                                    <i class="fas fa-envelope me-1"></i>Customer Email
                                </label>
                                <input type="email" 
                                       class="form-control @error('customer_email') is-invalid @enderror" 
                                       id="customer_email" 
                                       name="customer_email" 
                                       value="{{ old('customer_email', $order->customer_email) }}" 
                                       required>
                                @error('customer_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="customer_phone" class="form-label fw-bold text-burgundy">
                                    <i class="fas fa-phone me-1"></i>Customer Phone
                                </label>
                                <input type="text" 
                                       class="form-control @error('customer_phone') is-invalid @enderror" 
                                       id="customer_phone" 
                                       name="customer_phone" 
                                       value="{{ old('customer_phone', $order->customer_phone) }}">
                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="payment_method" class="form-label fw-bold text-burgundy">
                                    <i class="fas fa-credit-card me-1"></i>Payment Method
                                </label>
                                <select class="form-select @error('payment_method') is-invalid @enderror" 
                                        id="payment_method" 
                                        name="payment_method" 
                                        required>
                                    <option value="">Select Payment Method</option>
                                    <option value="Cash on Delivery" {{ old('payment_method', $order->payment_method) == 'Cash on Delivery' ? 'selected' : '' }}>
                                        Cash on Delivery
                                    </option>
                                    <option value="Mobile Money" {{ old('payment_method', $order->payment_method) == 'Mobile Money' ? 'selected' : '' }}>
                                        Mobile Money
                                    </option>
                                    <option value="Card" {{ old('payment_method', $order->payment_method) == 'Card' ? 'selected' : '' }}>
                                        Card
                                    </option>
                                </select>
                                @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label fw-bold text-burgundy">
                                    <i class="fas fa-tasks me-1"></i>Order Status
                                </label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" 
                                        name="status" 
                                        required>
                                    <option value="">Select Status</option>
                                    <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                    <option value="processing" {{ old('status', $order->status) == 'processing' ? 'selected' : '' }}>
                                        Processing
                                    </option>
                                    <option value="shipped" {{ old('status', $order->status) == 'shipped' ? 'selected' : '' }}>
                                        Shipped
                                    </option>
                                    <option value="delivered" {{ old('status', $order->status) == 'delivered' ? 'selected' : '' }}>
                                        Delivered
                                    </option>
                                    <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="shipping_address" class="form-label fw-bold text-burgundy">
                                    <i class="fas fa-map-marker-alt me-1"></i>Shipping Address
                                </label>
                                <textarea class="form-control @error('shipping_address') is-invalid @enderror" 
                                          id="shipping_address" 
                                          name="shipping_address" 
                                          rows="3" 
                                          required>{{ old('shipping_address', $order->shipping_address) }}</textarea>
                                @error('shipping_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="notes" class="form-label fw-bold text-burgundy">
                                    <i class="fas fa-sticky-note me-1"></i>Customer Notes
                                </label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" 
                                          id="notes" 
                                          name="notes" 
                                          rows="3">{{ old('notes', $order->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="admin_notes" class="form-label fw-bold text-burgundy">
                                    <i class="fas fa-clipboard me-1"></i>Admin Notes
                                </label>
                                <textarea class="form-control @error('admin_notes') is-invalid @enderror" 
                                          id="admin_notes" 
                                          name="admin_notes" 
                                          rows="3">{{ old('admin_notes', $order->admin_notes ?? '') }}</textarea>
                                @error('admin_notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-burgundy">
                                <i class="fas fa-times me-1"></i>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-burgundy">
                                <i class="fas fa-save me-1"></i>
                                Update Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Order Summary Sidebar -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 wine-card mb-4">
                <div class="card-header bg-gold text-burgundy">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-info-circle me-2"></i>
                        Order Summary
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <span class="text-muted small">Order ID:</span>
                        <div class="fw-bold text-burgundy">#{{ $order->id }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <span class="text-muted small">Order Date:</span>
                        <div class="fw-bold">{{ $order->created_at->format('M d, Y') }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <span class="text-muted small">Current Status:</span>
                        <div>
                            <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'processing' ? 'info' : ($order->status == 'shipped' ? 'primary' : ($order->status == 'delivered' ? 'success' : 'danger'))) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <span class="text-muted small">Total Amount:</span>
                        <div class="fw-bold text-burgundy fs-5">${{ number_format($order->total_amount, 2) }}</div>
                    </div>
                    
                    <div class="mb-3">
                        <span class="text-muted small">Items Count:</span>
                        <div class="fw-bold">
                            @php
                                $items = is_array($order->items) ? $order->items : json_decode($order->items, true);
                                $itemCount = is_array($items) ? count($items) : 0;
                            @endphp
                            {{ $itemCount }} items
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card shadow-sm border-0 wine-card">
                <div class="card-header bg-burgundy text-white">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-wine-bottle me-2"></i>
                        Order Items
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $items = is_array($order->items) ? $order->items : json_decode($order->items, true);
                    @endphp
                    @if(is_array($items) && count($items) > 0)
                        @foreach($items as $index => $item)
                            <div class="border-bottom pb-2 mb-2 {{ $index == count($items) - 1 ? 'border-0' : '' }}">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="fw-bold text-burgundy">{{ $item['wine_name'] ?? $item['item_name'] ?? 'Unknown Item' }}</div>
                                        <div class="text-muted small">
                                            Qty: {{ $item['quantity'] ?? 0 }} × ${{ number_format($item['unit_price'] ?? 0, 2) }}
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="fw-bold">${{ number_format(($item['quantity'] ?? 0) * ($item['unit_price'] ?? 0), 2) }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-3">
                            <i class="fas fa-wine-bottle fa-2x mb-2"></i>
                            <div>No items found</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.wine-card {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    border-radius: 15px;
    transition: all 0.3s ease;
}

.wine-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(94, 15, 15, 0.15) !important;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
    border: none;
}

.bg-burgundy {
    background: linear-gradient(135deg, var(--burgundy) 0%, var(--light-burgundy) 100%) !important;
}

.bg-gold {
    background: linear-gradient(135deg, var(--gold) 0%, var(--dark-gold) 100%) !important;
}

.btn-burgundy {
    background: linear-gradient(135deg, var(--burgundy) 0%, var(--light-burgundy) 100%);
    border: none;
    color: white;
    transition: all 0.3s ease;
}

.btn-burgundy:hover {
    background: linear-gradient(135deg, var(--light-burgundy) 0%, var(--burgundy) 100%);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(94, 15, 15, 0.3);
}

.btn-outline-burgundy {
    color: var(--burgundy);
    border-color: var(--burgundy);
    background: transparent;
}

.btn-outline-burgundy:hover {
    background: var(--burgundy);
    border-color: var(--burgundy);
    color: white;
}

.btn-outline-gold {
    color: var(--gold);
    border-color: var(--gold);
    background: transparent;
}

.btn-outline-gold:hover {
    background: var(--gold);
    border-color: var(--gold);
    color: var(--burgundy);
}

.form-control:focus, .form-select:focus {
    border-color: var(--gold);
    box-shadow: 0 0 0 0.2rem rgba(200, 169, 126, 0.25);
}

.text-burgundy {
    color: var(--burgundy) !important;
}

.badge {
    font-size: 0.75rem;
    padding: 0.5em 0.75em;
}

.page-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.page-title {
    font-size: 1.75rem;
    margin-bottom: 0.25rem;
}

.header-actions .btn {
    border-radius: 25px;
    padding: 0.5rem 1.25rem;
    font-weight: 500;
}
</style>
@endpush
@endsection 