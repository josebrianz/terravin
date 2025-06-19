@extends('layouts.app')

@section('title', 'Create New Wine Supply Request')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus"></i> Create New Wine Supply Request
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('procurement.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <!-- Supply Item Information -->
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Wine Supply Item Information</h6>
                                
                                <div class="mb-3">
                                    <label for="item_name" class="form-label">Supply Item Name *</label>
                                    <input type="text" class="form-control @error('item_name') is-invalid @enderror" 
                                           id="item_name" name="item_name" value="{{ old('item_name') }}" 
                                           placeholder="e.g., French Oak Barrels, Wine Bottles, Corks" required>
                                    @error('item_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="3" 
                                              placeholder="Detailed description of the wine supply item...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="quantity" class="form-label">Quantity *</label>
                                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                                   id="quantity" name="quantity" value="{{ old('quantity') }}" min="1" 
                                                   placeholder="Number of units" required>
                                            @error('quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="unit_price" class="form-label">Unit Price ($) *</label>
                                            <input type="number" class="form-control @error('unit_price') is-invalid @enderror" 
                                                   id="unit_price" name="unit_price" value="{{ old('unit_price') }}" 
                                                   step="0.01" min="0" placeholder="Price per unit" required>
                                            @error('unit_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="total_amount" class="form-label">Total Amount</label>
                                    <input type="text" class="form-control" id="total_amount" readonly>
                                </div>
                            </div>
                            
                            <!-- Supplier Information -->
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Wine Supply Supplier Information</h6>
                                
                                <div class="mb-3">
                                    <label for="supplier_name" class="form-label">Supplier Name *</label>
                                    <input type="text" class="form-control @error('supplier_name') is-invalid @enderror" 
                                           id="supplier_name" name="supplier_name" value="{{ old('supplier_name') }}" 
                                           placeholder="e.g., Wine Barrel Co., Premium Cork Suppliers" required>
                                    @error('supplier_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="supplier_email" class="form-label">Supplier Email</label>
                                    <input type="email" class="form-control @error('supplier_email') is-invalid @enderror" 
                                           id="supplier_email" name="supplier_email" value="{{ old('supplier_email') }}" 
                                           placeholder="contact@supplier.com">
                                    @error('supplier_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="supplier_phone" class="form-label">Supplier Phone</label>
                                    <input type="text" class="form-control @error('supplier_phone') is-invalid @enderror" 
                                           id="supplier_phone" name="supplier_phone" value="{{ old('supplier_phone') }}" 
                                           placeholder="+1-555-123-4567">
                                    @error('supplier_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="expected_delivery" class="form-label">Expected Delivery Date</label>
                                    <input type="date" class="form-control @error('expected_delivery') is-invalid @enderror" 
                                           id="expected_delivery" name="expected_delivery" value="{{ old('expected_delivery') }}">
                                    @error('expected_delivery')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              id="notes" name="notes" rows="3" 
                                              placeholder="Additional notes about this wine supply request...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Supply Categories Help -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-info-circle"></i> Common Wine Supply Categories:</h6>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <strong>Barrels & Aging:</strong><br>
                                            <small>Oak barrels, aging equipment</small>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Bottling:</strong><br>
                                            <small>Bottles, corks, capsules, labels</small>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Equipment:</strong><br>
                                            <small>Crushers, presses, pumps, filters</small>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Storage:</strong><br>
                                            <small>Racks, tanks, temperature control</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('procurement.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Supply Orders
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Supply Request
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

.alert-info {
    background-color: #d1ecf1;
    border-color: #bee5eb;
    color: #0c5460;
}
</style>
@endpush
@endsection 