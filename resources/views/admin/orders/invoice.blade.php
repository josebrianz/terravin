@extends('layouts.admin')

@section('title', 'Order Invoice')

@section('content')
<div class="container py-4" id="invoice-area">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2 class="fw-bold text-burgundy mb-1">Order Invoice</h2>
            <div class="text-muted">Order #{{ $order->id }} &mdash; {{ $order->created_at->format('M d, Y H:i') }}</div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <h5 class="fw-bold text-burgundy">Customer Info</h5>
            <div><span class="fw-bold">Name:</span> {{ $order->customer_name }}</div>
            <div><span class="fw-bold">Email:</span> {{ $order->customer_email }}</div>
            <div><span class="fw-bold">Phone:</span> {{ $order->customer_phone }}</div>
            <div><span class="fw-bold">Shipping Address:</span> {{ $order->shipping_address }}</div>
        </div>
        <div class="col-md-6 text-end">
            <h5 class="fw-bold text-burgundy">Order Info</h5>
            <div><span class="fw-bold">Status:</span> {{ ucfirst($order->status) }}</div>
            <div><span class="fw-bold">Order Date:</span> {{ $order->created_at->format('M d, Y H:i') }}</div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Item</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->item_name ?? $item['wine_name'] ?? '-' }}</td>
                        <td>UGX {{ number_format($item->unit_price ?? $item['unit_price'] ?? 0) }}</td>
                        <td>{{ $item->quantity ?? $item['quantity'] ?? 0 }}</td>
                        <td>UGX {{ number_format(($item->subtotal ?? ($item['quantity'] ?? 0 * $item['unit_price'] ?? 0))) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total</th>
                        <th>UGX {{ number_format($order->total_amount) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-center">
            <button class="btn btn-burgundy" onclick="window.print()"><i class="fas fa-print"></i> Print Invoice</button>
        </div>
    </div>
</div>
@push('styles')
<style>
@media print {
    body * { visibility: hidden; }
    #invoice-area, #invoice-area * { visibility: visible; }
    #invoice-area { position: absolute; left: 0; top: 0; width: 100%; }
    .btn { display: none !important; }
}
</style>
@endpush
@endsection 