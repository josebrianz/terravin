@extends('layouts.admin')

@section('title', 'Create New Wine Supply Request')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-plus me-2 text-gold"></i>
                        Create New Wine Supply Request
                    </h1>
                    <span class="text-muted small">Fill in the details to request a new wine supply item</span>
                </div>
                <div class="header-actions">
                    <a href="{{ route('procurement.dashboard') }}" class="btn btn-burgundy shadow-sm" title="Back to Dashboard">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="card wine-card shadow-sm border-0">
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
                                            <label for="unit_price" class="form-label">Unit Price (UGX) *</label>
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
        totalAmountInput.value = 'UGX ' + total.toFixed(0);
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
:root {
    --burgundy: #5e0f0f;
    --gold: #c8a97e;
    --cream: #f5f0e6;
    --light-burgundy: #8b1a1a;
    --dark-gold: #b8945f;
}

.wine-card {
    background: var(--cream);
    border-radius: 16px;
    border: 1px solid var(--gold);
    box-shadow: 0 4px 24px rgba(94, 15, 15, 0.07);
}

.card-body {
    background: var(--cream);
    border-radius: 16px;
}

.form-label {
    color: var(--burgundy);
    font-weight: 600;
}

input.form-control, textarea.form-control, select.form-control {
    border: 1px solid var(--gold);
    border-radius: 8px;
    background: #fff8f3;
    color: var(--burgundy);
}
input.form-control:focus, textarea.form-control:focus, select.form-control:focus {
    border-color: var(--burgundy);
    box-shadow: 0 0 0 2px var(--gold);
    background: #fff8f3;
    color: var(--burgundy);
}

.btn-burgundy {
    background: var(--burgundy);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    transition: background 0.2s;
}
.btn-burgundy:hover, .btn-burgundy:focus {
    background: var(--light-burgundy);
    color: #fff;
}

.btn-primary {
    background: var(--gold);
    color: var(--burgundy);
    border: none;
    border-radius: 8px;
    font-weight: 600;
    transition: background 0.2s;
}
.btn-primary:hover, .btn-primary:focus {
    background: var(--dark-gold);
    color: #fff;
}

.btn-secondary {
    background: #fff;
    color: var(--burgundy);
    border: 1px solid var(--gold);
    border-radius: 8px;
    font-weight: 600;
    transition: background 0.2s;
}
.btn-secondary:hover, .btn-secondary:focus {
    background: var(--gold);
    color: #fff;
}

.alert-info {
    background: #f8f5f0;
    border-color: var(--gold);
    color: var(--burgundy);
}

.page-header, .card-title, .header-actions {
    color: var(--burgundy);
}
</style>
@endpush
@endsection 