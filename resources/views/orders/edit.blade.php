@extends('layouts.app')

@section('title', 'Edit Order - Terravin Wine')

@section('content')
<div class="container py-4" style="max-width: 700px;">
    <div class="card shadow-lg" style="border-radius: 18px; border: none;">
        <div class="card-header" style="background: linear-gradient(90deg, #6b1a15 70%, #bfa14a 100%); color: #fff; border-radius: 18px 18px 0 0;">
            <h2 class="mb-0 fw-bold">Edit Order #{{ $order->id }}</h2>
        </div>
        <div class="card-body" style="background: #f8f6f3; border-radius: 0 0 18px 18px;">
            <form method="POST" action="{{ route('orders.update', $order->id) }}">
                @csrf
                @method('PUT')
                <h5 class="fw-bold mb-3 text-burgundy">Customer Information</h5>
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Customer Name *</label>
                        <input type="text" name="customer_name" class="form-control" value="{{ $order->customer_name }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" name="customer_email" class="form-control" value="{{ $order->customer_email }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone *</label>
                        <input type="text" name="customer_phone" class="form-control" value="{{ $order->customer_phone }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Shipping Address *</label>
                        <textarea name="shipping_address" class="form-control" required>{{ $order->shipping_address }}</textarea>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control">{{ $order->notes }}</textarea>
                    </div>
                </div>
                <h5 class="fw-bold mb-3 text-burgundy">Order Items</h5>
                <div class="mb-3">
                    <button type="button" class="btn btn-sm btn-gold mb-2" onclick="addItem()"><i class="fas fa-plus"></i> Add Item</button>
                </div>
                <div id="itemsContainer">
                    @if(is_array($order->items))
                        @foreach($order->items as $idx => $item)
                            <div class="border rounded p-3 mb-3 bg-white" id="item-{{ $idx }}">
                                <div class="row">
                                    <div class="col-md-5 mb-2">
                                        <label class="form-label">Wine Name *</label>
                                        <input type="text" class="form-control" name="items[{{ $idx }}][wine_name]" value="{{ $item['wine_name'] }}" required>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label class="form-label">Quantity *</label>
                                        <input type="number" class="form-control quantity-input" name="items[{{ $idx }}][quantity]" min="1" value="{{ $item['quantity'] }}" onchange="calculateTotal()" required>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label class="form-label">Unit Price *</label>
                                        <input type="number" class="form-control price-input" name="items[{{ $idx }}][unit_price]" step="0.01" min="0" value="{{ $item['unit_price'] }}" onchange="calculateTotal()" required>
                                    </div>
                                    <div class="col-md-1 d-flex align-items-end mb-2">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeItem({{ $idx }})"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="mb-3">
                    <h5 class="fw-bold text-burgundy">Total:</h5>
                    <div class="fs-5"><span id="totalAmount">UGX 0</span></div>
                    <input type="hidden" id="totalAmountInput" name="total_amount" value="0">
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Order Status</label>
                        <select name="status" class="form-select">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-burgundy">Cancel</a>
                    <button type="submit" class="btn btn-gold">Update Order</button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
.text-burgundy { color: #6b1a15; }
.btn-gold { background: #bfa14a; color: #fff; border: none; }
.btn-gold:hover { background: #a68c2c; color: #fff; }
.btn-outline-burgundy { border: 1px solid #6b1a15; color: #6b1a15; background: #fff; }
.btn-outline-burgundy:hover { background: #6b1a15; color: #fff; }
</style>
<script>
let itemCount = {{ is_array($order->items) ? count($order->items) : 0 }};
function addItem() {
    itemCount++;
    const container = document.getElementById('itemsContainer');
    const itemHtml = `
        <div class="border rounded p-3 mb-3 bg-white" id="item-${itemCount}">
            <div class="row">
                <div class="col-md-5 mb-2">
                    <label class="form-label">Wine Name *</label>
                    <input type="text" class="form-control" name="items[${itemCount}][wine_name]" required>
                </div>
                <div class="col-md-3 mb-2">
                    <label class="form-label">Quantity *</label>
                    <input type="number" class="form-control quantity-input" name="items[${itemCount}][quantity]" min="1" value="1" onchange="calculateTotal()" required>
                </div>
                <div class="col-md-3 mb-2">
                    <label class="form-label">Unit Price *</label>
                    <input type="number" class="form-control price-input" name="items[${itemCount}][unit_price]" step="0.01" min="0" value="0" onchange="calculateTotal()" required>
                </div>
                <div class="col-md-1 d-flex align-items-end mb-2">
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeItem(${itemCount})"><i class="fas fa-trash"></i></button>
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
        subtotalInputs[i].value = `UGX ${subtotal.toFixed(0)}`;
        total += subtotal;
    }
    document.getElementById('totalAmount').textContent = `UGX ${total.toFixed(0)}`;
    document.getElementById('totalAmountInput').value = total.toFixed(2);
}
document.addEventListener('DOMContentLoaded', function() {
    calculateTotal();
});
</script>
@endsection