@extends('layouts.app')

@section('title', 'Order Confirmation - Terravin Wine')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mt-5">
                <div class="card-body text-center py-5">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <h2 class="fw-bold text-burgundy mb-3">Thank you for your order!</h2>
                    <p class="text-muted mb-4">Your order has been placed successfully. We will process it soon and keep you updated.</p>
                    <div class="order-summary-box text-start mx-auto mb-4" style="max-width: 500px;">
                        <h5 class="fw-bold text-burgundy mb-3">Order Summary</h5>
                        <div class="mb-2">
                            <span class="fw-bold">Order ID:</span> #{{ $order->id }}
                        </div>
                        <div class="mb-2">
                            <span class="fw-bold">Customer:</span> {{ $order->customer_name }}<br>
                            <span class="fw-bold">Email:</span> {{ $order->customer_email }}<br>
                            <span class="fw-bold">Phone:</span> {{ $order->customer_phone }}
                        </div>
                        <div class="mb-2">
                            <span class="fw-bold">Shipping Address:</span> {{ $order->shipping_address }}
                        </div>
                        <div class="mb-2">
                            <span class="fw-bold">Order Status:</span> <span class="badge bg-info text-dark">{{ ucfirst($order->status) }}</span>
                        </div>
                        <hr>
                        <div class="mb-2">
                            <span class="fw-bold">Items:</span>
                            <ul class="list-unstyled ms-3">
                                @foreach($order->items as $item)
                                <li class="mb-1">
                                    <img src="{{ $item->item_image }}" alt="{{ $item->item_name }}" class="me-2" style="width:32px;height:48px;object-fit:cover;border-radius:4px;">
                                    <span class="fw-bold">{{ $item->item_name }}</span> x {{ $item->quantity }}
                                    <span class="text-muted">(UGX {{ number_format($item->unit_price) }} each)</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="mb-2">
                            <span class="fw-bold">Total:</span> <span class="text-burgundy fw-bold fs-5">UGX {{ number_format($order->total_amount) }}</span>
                        </div>
                    </div>
                    <a href="{{ route('orders.catalog') }}" class="btn btn-burgundy mt-3">
                        <i class="fas fa-arrow-left"></i> Back to Catalog
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@push('styles')
<style>
.text-burgundy { color: #5e0f0f !important; }
.btn-burgundy { background-color: #5e0f0f; border-color: #5e0f0f; color: white; }
.btn-burgundy:hover { background-color: #8b1a1a; border-color: #8b1a1a; color: white; }
.order-summary-box { background: #f5f0e6; border-radius: 12px; padding: 1.5rem; }
</style>
@endpush
@endsection 