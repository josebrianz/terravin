@extends('layouts.app')

@section('title', 'Order Confirmation')

@section('content')
<div class="container py-5 text-center">
    <h2 class="mb-4 text-burgundy fw-bold">Thank You for Your Order!</h2>
    <div class="alert alert-success mb-4">Your order has been placed successfully. Below is your order summary.</div>
    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <h4 class="mb-3">Order #{{ $order->id }}</h4>
            @php
                $items = is_string($order->items) ? json_decode($order->items, true) : $order->items;
            @endphp
            <ul class="list-group mb-3 text-start">
                @foreach($items as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $item['wine_name'] }}</strong>
                            <span class="text-muted">x{{ $item['quantity'] }}</span>
                        </div>
                        <span>{{ format_usd($item['unit_price'] * $item['quantity']) }}</span>
                    </li>
                @endforeach
            </ul>
            <h5 class="fw-bold text-burgundy">Total: {{ format_usd($order->total_amount) }}</h5>
        </div>
    </div>
    <a href="{{ route('customer.dashboard') }}" class="btn btn-burgundy mt-4">Back to Dashboard</a>
</div>
@endsection 