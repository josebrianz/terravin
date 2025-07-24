@extends('layouts.admin')

@section('title', 'Create New Wine Supply Request')

@section('content')
<div class="container-fluid d-flex justify-content-center align-items-center min-vh-100" style="background: #f9f5f0;">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-header bg-burgundy text-white">
                    <h3 class="mb-0"><i class="fas fa-wine-bottle me-2"></i> Create New Supply Request</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('procurement.store') }}" enctype="multipart/form-data">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <!-- Main Card with Sections -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header">
                                <h5 class="mb-0 text-burgundy"><i class="fas fa-wine-glass-alt me-2"></i>Wine Supply Details</h5>
                            </div>
                            <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                        <!-- Supplier Selection -->
                                        <div class="mb-4">
                                            <label for="supplier_id" class="form-label fw-bold">Supplier *</label>
                                            <select name="supplier_id" id="supplier_id" class="form-select form-select-lg" required>
                                                <option value="">Select a supplier...</option>
                                                @foreach($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}" data-email="{{ $supplier->email }}">{{ $supplier->name }} ({{ $supplier->email }})</option>
                                                @endforeach
                                            </select>
                                            <div class="mt-2 text-muted" id="supplier-email-display"></div>
                                        </div>
                                        <!-- Raw Material Selection (filtered by supplier) -->
                                        <div class="mb-4">
                                            <label for="item_name" class="form-label fw-bold">Raw Material *</label>
                                            <select name="item_name" id="item_name" class="form-select form-select-lg" required disabled>
                                                <option value="">Select a supplier first...</option>
                                            </select>
                                    @error('item_name')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                        <div class="mb-4">
                                            <label for="description" class="form-label fw-bold">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="3" 
                                                      placeholder="Enter any special instructions or details about this material...">{{ old('description') }}</textarea>
                                    @error('description')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                        </div>
                                </div>
                                
                                    <div class="col-md-6">
                                        <h6 class="text-burgundy mb-3 fw-bold">Order Information</h6>
                                        <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                                    <label for="quantity" class="form-label fw-bold">Quantity *</label>
                                                    <div class="input-group input-group-lg">
                                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                                   id="quantity" name="quantity" value="{{ old('quantity') }}" min="1" 
                                                               placeholder="0" required>
                                                        <span class="input-group-text bg-white" id="quantity-unit">unit</span>
                                                    </div>
                                            @error('quantity')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                                    <label for="unit_price" class="form-label fw-bold">Unit Price ($) *</label>
                                                    <div class="input-group input-group-lg">
                                                        <span class="input-group-text bg-white">$</span>
                                            <input type="number" class="form-control @error('unit_price') is-invalid @enderror" 
                                                   id="unit_price" name="unit_price" value="{{ old('unit_price') }}" 
                                                               step="0.01" min="0" placeholder="0.00" required>
                                                    </div>
                                            @error('unit_price')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                            <label for="total_amount" class="form-label fw-bold">Total Amount</label>
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text bg-white">$</span>
                                                <input type="text" class="form-control fw-bold text-success" id="total_amount" readonly>
                                </div>
                            </div>
                                </div>
                                </div>
                                
                                <!-- Date Fields -->
                                <div class="row mt-3 g-3">
                                    <div class="col-md-4">
                                <div class="mb-3">
                                            <label for="order_date" class="form-label fw-bold">Order Date</label>
                                            <input type="date" class="form-control form-control-lg" id="order_date" name="order_date" value="{{ old('order_date') }}">
                                        </div>
                                        </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="expected_delivery_date" class="form-label fw-bold">Expected Delivery</label>
                                            <input type="date" class="form-control form-control-lg" id="expected_delivery_date" name="expected_delivery_date" value="{{ old('expected_delivery_date') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('procurement.index') }}" class="btn btn-outline-burgundy btn-lg">
                                <i class="fas fa-arrow-left me-2"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-burgundy btn-lg px-4">
                                <i class="fas fa-save me-2"></i> Submit Request
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
    const suppliers = @json($suppliers);
    const rawMaterials = @json($rawMaterials);
    const supplierSelect = document.getElementById('supplier_id');
    const supplierEmailDisplay = document.getElementById('supplier-email-display');
    const itemNameSelect = document.getElementById('item_name');
    const quantityInput = document.getElementById('quantity');
    const unitPriceInput = document.getElementById('unit_price');
    const totalAmountInput = document.getElementById('total_amount');
    const quantityUnit = document.getElementById('quantity-unit');

    // Helper: Filter materials by supplier
    function getMaterialsForSupplier(supplierId) {
        return rawMaterials.filter(m => m.user_id == supplierId);
    }

    // When supplier changes, update email display and material dropdown
    supplierSelect.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        const supplierId = this.value;
        const email = selected.getAttribute('data-email') || '';
        supplierEmailDisplay.textContent = email ? `Email: ${email}` : '';
        // Update material dropdown
        itemNameSelect.innerHTML = '';
        if (!supplierId) {
            itemNameSelect.disabled = true;
            itemNameSelect.innerHTML = '<option value="">Select a supplier first...</option>';
            unitPriceInput.value = '';
            quantityUnit.textContent = 'unit';
            return;
        }
        const materials = getMaterialsForSupplier(supplierId);
        if (materials.length === 0) {
            itemNameSelect.disabled = true;
            itemNameSelect.innerHTML = '<option value="">No materials for this supplier</option>';
            unitPriceInput.value = '';
            quantityUnit.textContent = 'unit';
            return;
        }
        itemNameSelect.disabled = false;
        itemNameSelect.innerHTML = '<option value="">Select a raw material...</option>' +
            materials.map(m => `<option value="${m.name}" data-unit-price="${m.unit_price}" data-stock-level="${m.stock_level}">${m.name}</option>`).join('');
        // Reset price/unit
        unitPriceInput.value = '';
        quantityUnit.textContent = 'unit';
    });

    // When material changes, update price/unit
    itemNameSelect.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        const price = selected.getAttribute('data-unit-price') || '';
        const stockLevel = selected.getAttribute('data-stock-level') || '';
        
        // Set unit price - if no price from material, allow manual entry
        if (price && price !== '0' && price !== '0.00') {
        unitPriceInput.value = price;
        } else {
            unitPriceInput.value = '';
            unitPriceInput.placeholder = 'Enter unit price...';
        }
        
        console.log('Selected material:', selected.value);
        console.log('Unit price:', price);
        console.log('Stock level:', stockLevel);
        
        // Extract unit from stockLevel
        let unit = 'unit';
        if (stockLevel) {
            const match = stockLevel.match(/([a-zA-Z]+)/);
            if (match) unit = match[1];
        }
        quantityUnit.textContent = unit;
        calculateTotal();
    });
    
    function calculateTotal() {
        const quantity = parseFloat(quantityInput.value) || 0;
        const unitPrice = parseFloat(unitPriceInput.value) || 0;
        const total = quantity * unitPrice;
        console.log('Quantity:', quantity);
        console.log('Unit Price:', unitPrice);
        console.log('Total:', total);
        totalAmountInput.value = total.toFixed(2);
    }
    
    quantityInput.addEventListener('input', calculateTotal);
    unitPriceInput.addEventListener('input', calculateTotal);
    
    // Initial state
    itemNameSelect.disabled = true;
    unitPriceInput.value = '';
    quantityUnit.textContent = 'unit';
    supplierEmailDisplay.textContent = '';
});
</script>
@endpush

@push('styles')
<style>
:root {
    --burgundy: #6a0f1a;
    --light-burgundy: #8b1a1a;
    --dark-burgundy: #4a0a12;
    --gold: #c8a97e;
    --light-gold: #e5d7bf;
    --cream: #f9f5f0;
    --dark-gold: #b8945f;
}

body {
    background-color: var(--cream);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.bg-burgundy {
    background-color: var(--burgundy) !important;
}

.text-burgundy {
    color: var(--burgundy) !important;
}

.btn-burgundy {
    background-color: var(--burgundy) !important;
    color: white !important;
    border-color: var(--burgundy) !important;
}

.btn-outline-burgundy {
    color: var(--burgundy) !important;
    border-color: var(--burgundy) !important;
    background-color: transparent !important;
}

.btn-burgundy:hover, .btn-burgundy:focus {
    background-color: var(--dark-burgundy) !important;
    border-color: var(--dark-burgundy) !important;
    color: var(--light-gold) !important;
}

.btn-outline-burgundy:hover, .btn-outline-burgundy:focus {
    background-color: var(--burgundy) !important;
    color: white !important;
}

.wine-card {
    max-width: 1600px;
    width: 100%;
    margin: 0 auto;
    border-radius: 16px;
    overflow: hidden;
    border: none;
}

.card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.form-control, .form-select {
    padding: 0.75rem 1rem;
    border: 1px solid #ddd;
    transition: all 0.3s;
}

.form-control:focus, .form-select:focus {
    border-color: var(--gold);
    box-shadow: 0 0 0 0.25rem rgba(200, 169, 126, 0.25);
}

.form-control-lg, .form-select-lg {
    padding: 1rem 1.25rem;
    font-size: 1.05rem;
}

.input-group-text {
    background-color: white;
    border: 1px solid #ddd;
}

label {
    font-weight: 500;
    margin-bottom: 0.5rem;
    color: #555;
}

.fw-bold {
    color: var(--dark-burgundy);
}

.invalid-feedback {
    font-size: 0.85rem;
    margin-top: 0.25rem;
}

.bg-light {
    background-color: var(--light-gold) !important;
}

.rounded {
    border-radius: 10px !important;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.container-fluid.d-flex {
    min-height: 100vh;
    padding-top: 0;
    padding-bottom: 0;
}

.col-12.col-lg-10.col-xl-8 {
    max-width: 1600px;
    width: 98vw;
}

@media (max-width: 768px) {
    .card-body {
        padding: 1.25rem;
    }
    
    .btn-lg {
        padding: 0.5rem 1rem;
        font-size: 1rem;
    }
}
</style>
@endpush
@endsection 