@extends('layouts.app')

@section('title', 'Edit Order - Terravin Wine')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="fw-bold">
                <i class="fas fa-edit me-2"></i>Edit Order #{{ $order->id }}
            </h1>
        </div>
    </div>
    <form action="{{ route('orders.update', $order) }}" method="POST" id="orderForm">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="fw-bold">Customer Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Customer Name *</label>
                            <input type="text" class="form-control" name="customer_name" value="{{ $order->customer_name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" class="form-control" name="customer_email" value="{{ $order->customer_email }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone *</label>
                            <input type="text" class="form-control" name="customer_phone" value="{{ $order->customer_phone }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Shipping Address *</label>
                            <textarea class="form-control" name="shipping_address" rows="3" required>{{ $order->shipping_address }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" rows="2">{{ $order->notes }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="fw-bold">Order Items</h5>
                        <button type="button" class="btn btn-sm btn-primary" onclick="addItem()">Add Item</button>
                    </div>
                    <div class="card-body">
                        <div id="itemsContainer">
                            @foreach($order->items as $idx => $item)
                            <div class="border rounded p-3 mb-3" id="item-{{ $idx }}">
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label class="form-label">Wine Name *</label>
                                        <input type="text" class="form-control" name="items[{{ $idx }}][wine_name]" value="{{ $item['wine_name'] }}" required>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <label class="form-label">Quantity *</label>
                                        <input type="number" class="form-control quantity-input" name="items[{{ $idx }}][quantity]" min="1" value="{{ $item['quantity'] }}" onchange="calculateTotal()" required>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <label class="form-label">Unit Price *</label>
                                        <input type="number" class="form-control price-input" name="items[{{ $idx }}][unit_price]" step="0.01" min="0" value="{{ $item['unit_price'] }}" onchange="calculateTotal()" required>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <label class="form-label">Subtotal</label>
                                        <input type="text" class="form-control subtotal-input" value="$ {{ number_format($item['quantity'] * $item['unit_price'], 2) }}" readonly>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <label class="form-label">&nbsp;</label>
                                        <button type="button" class="btn btn-danger btn-sm d-block w-100" onclick="removeItem({{ $idx }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <h5 class="text-end">Total:</h5>
                            </div>
                            <div class="col-6">
                                <h5 class="text-primary" id="totalAmount">$0.00</h5>
                                <input type="hidden" name="total_amount" id="totalAmountInput" value="{{ $order->total_amount }}">
                            </div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label class="form-label">Order Status</label>
                            <select class="form-select" name="status" required>
                                <option value="pending" @if($order->status=='pending') selected @endif>Pending</option>
                                <option value="processing" @if($order->status=='processing') selected @endif>Processing</option>
                                <option value="shipped" @if($order->status=='shipped') selected @endif>Shipped</option>
                                <option value="delivered" @if($order->status=='delivered') selected @endif>Delivered</option>
                                <option value="cancelled" @if($order->status=='cancelled') selected @endif>Cancelled</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-end">
            <a href="{{ route('orders.show', $order) }}" class="btn btn-secondary me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Order</button>
        </div>
    </form>
</div>
<script>
let itemCount = {{ count($order->items) }};
function addItem() {
    itemCount++;
    const container = document.getElementById('itemsContainer');
    const itemHtml = `
        <div class="border rounded p-3 mb-3" id="item-${itemCount}">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <label class="form-label">Wine Name *</label>
                    <input type="text" class="form-control" name="items[${itemCount}][wine_name]" required>
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label">Quantity *</label>
                    <input type="number" class="form-control quantity-input" name="items[${itemCount}][quantity]" min="1" value="1" onchange="calculateTotal()" required>
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label">Unit Price *</label>
                    <input type="number" class="form-control price-input" name="items[${itemCount}][unit_price]" step="0.01" min="0" value="0" onchange="calculateTotal()" required>
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label">Subtotal</label>
                    <input type="text" class="form-control subtotal-input" readonly>
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-sm d-block w-100" onclick="removeItem(${itemCount})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', itemHtml);
    calculateTotal();
}
function removeItem(itemId) {
    const item = document.getElementById(`item-${itemId}`);
    item.remove();
    calculateTotal();
}
function calculateTotal() {
    let total = 0;
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const priceInputs = document.querySelectorAll('.price-input');
    const subtotalInputs = document.querySelectorAll('.subtotal-input');
    for (let i = 0; i < quantityInputs.length; i++) {
        const quantity = parseFloat(quantityInputs[i].value) || 0;
        const price = parseFloat(priceInputs[i].value) || 0;
        const subtotal = quantity * price;
        subtotalInputs[i].value = `$${subtotal.toFixed(2)}`;
        total += subtotal;
    }
    document.getElementById('totalAmount').textContent = `$${total.toFixed(2)}`;
    document.getElementById('totalAmountInput').value = total.toFixed(2);
}
document.addEventListener('DOMContentLoaded', function() {
    calculateTotal();
});
</script>
@endsection 