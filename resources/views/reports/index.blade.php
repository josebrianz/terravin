@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Reports Dashboard</h1>
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Orders</h5>
                    <p class="display-6 fw-bold">{{ $totalOrders }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Inventory Items</h5>
                    <p class="display-6 fw-bold">{{ $totalInventory }}</p>
                </div>
            </div>
        </div>
        @if(!is_null($totalProcurements))
        <div class="col-md-4">
            <div class="card text-center shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Procurements</h5>
                    <p class="display-6 fw-bold">{{ $totalProcurements }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <h4>Recent Orders</h4>
            <ul class="list-group mb-4">
                @foreach(\App\Models\Order::latest()->take(5)->get() as $order)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Order #{{ $order->id }} - {{ $order->customer_name }}</span>
                        <span class="badge bg-info">{{ ucfirst($order->status) }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-6">
            <h4>Recent Procurements</h4>
            @if(class_exists('App\\Models\\Procurement'))
            <ul class="list-group mb-4">
                @foreach(\App\Models\Procurement::latest()->take(5)->get() as $procurement)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Procurement #{{ $procurement->id }} - {{ $procurement->status }}</span>
                        <span class="badge bg-secondary">UGX {{ number_format($procurement->total_amount ?? 0) }}</span>
                    </li>
                @endforeach
            </ul>
            @else
            <p>No procurement data available.</p>
            @endif
        </div>
    </div>
</div>
@endsection 