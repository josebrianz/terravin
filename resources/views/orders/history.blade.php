@extends('layouts.app')

@section('title', 'Order History')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-burgundy fw-bold">Your Order History</h2>
    @if($orders->isEmpty())
        <div class="alert alert-info">You have not placed any orders yet.</div>
    @else
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Items</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td><span class="badge bg-info text-dark">{{ ucfirst($order->status) }}</span></td>
                            <td>UGX {{ number_format($order->total, 0) }}</td>
                            <td>
                                <ul class="list-unstyled mb-0">
                                    @foreach($order->orderItems as $item)
                                        <li>
                                            <strong>{{ $item->inventory->name }}</strong> x{{ $item->quantity }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-burgundy mt-4">Back to Dashboard</a>
</div>
@endsection 