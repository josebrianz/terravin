@extends('layouts.admin')

@section('title', 'Order Details - Admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-receipt me-2 text-gold"></i>
                        Order #{{ $order->id }}
                    </h1>
                    <span class="text-muted small">Order details and management</span>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-burgundy">
                        <i class="fas fa-arrow-left"></i> Back to Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-user me-2 text-gold"></i> Customer Info
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-2"><span class="fw-bold">Name:</span> {{ $order->customer_name }}</div>
                    <div class="mb-2"><span class="fw-bold">Email:</span> {{ $order->customer_email }}</div>
                    <div class="mb-2"><span class="fw-bold">Phone:</span> {{ $order->customer_phone }}</div>
                    <div class="mb-2"><span class="fw-bold">Shipping Address:</span> {{ $order->shipping_address }}</div>
                    <div class="mb-2"><span class="fw-bold">Notes:</span> {{ $order->notes ?? '-' }}</div>
                    <div class="mb-2"><span class="fw-bold">Order Date:</span> {{ $order->created_at->format('M d, Y H:i') }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-cogs me-2 text-gold"></i> Manage Status
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.orders.update-status', $order->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="status" class="form-label fw-bold text-burgundy">Order Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="pending" @if($order->status=='pending') selected @endif>Pending</option>
                                <option value="processing" @if($order->status=='processing') selected @endif>Processing</option>
                                <option value="shipped" @if($order->status=='shipped') selected @endif>Shipped</option>
                                <option value="delivered" @if($order->status=='delivered') selected @endif>Delivered</option>
                                <option value="cancelled" @if($order->status=='cancelled') selected @endif>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-burgundy">
                            <i class="fas fa-save"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-boxes me-2 text-gold"></i> Order Items
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Image</th>
                                    <th>Item</th>
                                    <th>Unit Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td><img src="{{ $item->item_image }}" alt="{{ $item->item_name }}" style="width:40px;height:60px;object-fit:cover;border-radius:4px;"></td>
                                    <td>{{ $item->item_name }}</td>
                                    <td>UGX {{ number_format($item->unit_price) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>UGX {{ number_format($item->subtotal) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white d-flex justify-content-end">
                    <span class="fw-bold text-burgundy fs-5">Total: UGX {{ number_format($order->total_amount) }}</span>
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
</style>
@endpush
@endsection 