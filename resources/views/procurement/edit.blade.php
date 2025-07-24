@extends('layouts.app')

@section('title', 'Edit Wine Supply Order')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit"></i> Edit Wine Supply Order
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('procurement.update', $procurement) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Supply Item Information -->
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Wine Supply Item Information</h6>
                                
                                <div class="mb-3">
                                    <label for="item_name" class="form-label">Supply Item Name *</label>
                                    <input type="text" class="form-control @error('item_name') is-invalid @enderror" 
                                           id="item_name" name="item_name" value="{{ old('item_name', $procurement->item_name) }}" 
                                           placeholder="e.g., French Oak Barrels, Wine Bottles, Corks" required>
                                    @error('item_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="3" 
                                              placeholder="Detailed description of the wine supply item...">{{ old('description', $procurement->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="quantity" class="form-label">Quantity *</label>
                                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                                   id="quantity" name="quantity" value="{{ old('quantity', $procurement->quantity) }}" min="1" 
                                                   placeholder="Number of units" required>
                                            @error('quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="unit_price" class="form-label">Unit Price (USD) *</label>
                                            <input type="number" class="form-control @error('unit_price') is-invalid @enderror" 
                                                   id="unit_price" name="unit_price" value="{{ old('unit_price', $procurement->unit_price) }}" 
                                                   step="0.01" min="0" placeholder="Price per unit" required>
                                            @error('unit_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="total_amount" class="form-label">Total Amount</label>
                                    <input type="text" class="form-control" id="total_amount" readonly 
                                           value="${{ number_format($procurement->total_amount, 2) }}">
                                </div>
                            </div>
                            
                            <!-- Wholesaler Information -->
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3"> Raw Material Supplier Information</h6>
                                
                                <div class="mb-3">
                                    <label for="wholesaler_name" class="form-label">Supplier Name *</label>
                                    <input type="text" class="form-control @error('wholesaler_name') is-invalid @enderror" 
                                           id="wholesaler_name" name="wholesaler_name" value="{{ old('wholesaler_name', $procurement->wholesaler_name) }}" 
                                           placeholder="e.g., Wine Barrel Co., Premium Cork Wholesalers" required>
                                    @error('wholesaler_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="wholesaler_email" class="form-label">Supplier Email</label>
                                    <input type="email" class="form-control @error('wholesaler_email') is-invalid @enderror" 
                                           id="wholesaler_email" name="wholesaler_email" value="{{ old('wholesaler_email', $procurement->wholesaler_email) }}" 
                                           placeholder="contact@wholesaler.com">
                                    @error('wholesaler_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="wholesaler_phone" class="form-label">Supplier Phone</label>
                                    <input type="text" class="form-control @error('wholesaler_phone') is-invalid @enderror" 
                                           id="wholesaler_phone" name="wholesaler_phone" value="{{ old('wholesaler_phone', $procurement->wholesaler_phone) }}" 
                                           placeholder="+1-555-123-4567">
                                    @error('wholesaler_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status *</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="pending" {{ old('status', $procurement->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ old('status', $procurement->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="ordered" {{ old('status', $procurement->status) == 'ordered' ? 'selected' : '' }}>On Order</option>
                                        <option value="received" {{ old('status', $procurement->status) == 'received' ? 'selected' : '' }}>Received</option>
                                        <option value="cancelled" {{ old('status', $procurement->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Dates Section -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">Important Dates</h6>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="order_date" class="form-label">Order Date</label>
                                    <input type="date" class="form-control @error('order_date') is-invalid @enderror" 
                                           id="order_date" name="order_date" 
                                           value="{{ old('order_date', $procurement->order_date ? $procurement->order_date->format('Y-m-d') : '') }}">
                                    @error('order_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="expected_delivery" class="form-label">Expected Delivery Date</label>
                                    <input type="date" class="form-control @error('expected_delivery') is-invalid @enderror" 
                                           id="expected_delivery" name="expected_delivery" 
                                           value="{{ old('expected_delivery', $procurement->expected_delivery ? $procurement->expected_delivery->format('Y-m-d') : '') }}">
                                    @error('expected_delivery')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="actual_delivery" class="form-label">Actual Delivery Date</label>
                                    <input type="date" class="form-control @error('actual_delivery') is-invalid @enderror" 
                                           id="actual_delivery" name="actual_delivery" 
                                           value="{{ old('actual_delivery', $procurement->actual_delivery ? $procurement->actual_delivery->format('Y-m-d') : '') }}">
                                    @error('actual_delivery')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Notes -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              id="notes" name="notes" rows="4" 
                                              placeholder="Additional notes about this wine supply order...">{{ old('notes', $procurement->notes) }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('procurement.show', $procurement) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Details
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Supply Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity');
    const unitPriceInput = document.getElementById('unit_price');
    const totalAmountInput = document.getElementById('total_amount');
    
    function calculateTotal() {
        const quantity = parseFloat(quantityInput.value) || 0;
        const unitPrice = parseFloat(unitPriceInput.value) || 0;
        const total = quantity * unitPrice;
        totalAmountInput.value = '$' + total.toFixed(2);
    }
    
    quantityInput.addEventListener('input', calculateTotal);
    unitPriceInput.addEventListener('input', calculateTotal);
    
    // Calculate initial total
    calculateTotal();
});
</script>
@endpush

@push('styles')
<style>
.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.text-primary {
    color: #0d6efd !important;
}

.form-label {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.invalid-feedback {
    display: block;
}
</style>
@endpush
@endsection 