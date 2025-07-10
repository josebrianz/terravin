@extends('layout')

@section('content')
<div class="container py-5">
    <a href="{{ route('retailer.orders') }}" class="btn btn-link mb-3"><i class="fas fa-arrow-left me-1"></i> Back to Orders</a>
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h2 class="mb-3">Order #{{ $order->id }}</h2>
            <div class="mb-2"><span class="badge {{ $order->status_badge }} text-capitalize">{{ ucfirst($order->status) }}</span></div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <h5>Order Details</h5>
                    <ul class="list-unstyled mb-0">
                        <li><strong>Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</li>
                        <li><strong>Total:</strong> UGX {{ number_format($order->total_amount, 0, '.', ',') }}</li>
                        <li><strong>Status:</strong> <span class="text-capitalize">{{ $order->status }}</span></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h5>Customer Info</h5>
                    <ul class="list-unstyled mb-0">
                        <li><strong>Name:</strong> {{ $order->customer_name }}</li>
                        <li><strong>Email:</strong> {{ $order->customer_email }}</li>
                        <li><strong>Phone:</strong> {{ $order->customer_phone }}</li>
                        <li><strong>Shipping Address:</strong> {{ $order->shipping_address }}</li>
                    </ul>
                </div>
            </div>
            <h5 class="mt-4">Order Items</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item['wine_name'] ?? '-' }}</td>
                            <td>{{ $item['wine_category'] ?? '-' }}</td>
                            <td>{{ $item['quantity'] ?? '-' }}</td>
                            <td>UGX {{ number_format($item['unit_price'] ?? 0, 0, '.', ',') }}</td>
                            <td>UGX {{ number_format(($item['unit_price'] ?? 0) * ($item['quantity'] ?? 0), 0, '.', ',') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-end mt-3">
                <h5><strong>Total: UGX {{ number_format($order->total_amount, 0, '.', ',') }}</strong></h5>
            </div>
            @if($order->notes)
            <div class="mt-3">
                <h6>Notes:</h6>
                <p>{{ $order->notes }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 