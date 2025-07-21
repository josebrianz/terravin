@extends('layouts.admin')

@section('title', 'Create New Wine Order - Terravin Wine')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-plus me-2 text-gold"></i>
                        Create New Wine Order
                    </h1>
                    <span class="text-muted small">Add a new customer order for wine products</span>
                </div>
                <div class="header-actions">
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-burgundy" title="Back to orders">
                        <i class="fas fa-arrow-left"></i> Back to Orders
                    </a>
                    <span class="badge bg-gold text-burgundy px-3 py-2 ms-3">
                        <i class="fas fa-clock me-1"></i>
                        {{ now()->format('M d, Y H:i') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
        @csrf
        
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card wine-card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom-0">
                        <h5 class="card-title mb-0 fw-bold text-burgundy">
                            <i class="fas fa-user text-gold me-2"></i> Customer Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="customer_name" class="form-label fw-bold text-burgundy">Customer Name *</label>
                            <input type="text" class="form-control" name="customer_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer_email" class="form-label fw-bold text-burgundy">Email *</label>
                            <input type="email" class="form-control" name="customer_email" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer_phone" class="form-label fw-bold text-burgundy">Phone *</label>
                            <input type="text" class="form-control" name="customer_phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="shipping_address" class="form-label fw-bold text-burgundy">Shipping Address *</label>
                            <textarea class="form-control" name="shipping_address" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label fw-bold text-burgundy">Notes</label>
                            <textarea class="form-control" name="notes" rows="2" placeholder="Any special instructions or notes..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card wine-card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold text-burgundy">
                            <i class="fas fa-wine-bottle text-gold me-2"></i> Order Items
                        </h5>
                        <button type="button" class="btn btn-burgundy btn-sm" onclick="addItem()" title="Add wine item">
                            <i class="fas fa-plus"></i> Add Wine Item
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="itemsContainer"></div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <h5 class="text-end fw-bold text-burgundy">Total:</h5>
                            </div>
                            <div class="col-6">
                                <h5 class="text-burgundy fw-bold" id="totalAmount">UGX 0</h5>
                                <input type="hidden" name="total_amount" id="totalAmountInput" value="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end mt-4">
            <a href="{{ route('orders.index') }}" class="btn btn-outline-burgundy me-2">
                <i class="fas fa-times"></i> Cancel
            </a>
            <button type="submit" class="btn btn-burgundy">
                <i class="fas fa-save"></i> Create Wine Order
            </button>
        </div>
    </form>
</div>

<script>
let itemCount = 0;
const wineItems = @json(\App\Models\Inventory::where('is_active', true)->get());

function addItem() {
    itemCount++;
    const container = document.getElementById('itemsContainer');
    
    // Create wine options HTML
    let wineOptions = '<option value="">Select a wine...</option>';
    wineItems.forEach(wine => {
        const stockStatus = wine.quantity > 0 ? `(In Stock: ${wine.quantity})` : '(Out of Stock)';
        wineOptions += `<option value="${wine.id}" data-price="${wine.unit_price}" data-stock="${wine.quantity}">${wine.name} - ${wine.category} - UGX ${wine.unit_price} ${stockStatus}</option>`;
    });
    
    const itemHtml = `
        <div class="border rounded p-3 mb-3 wine-list-item" id="item-${itemCount}">
            <div class="row g-2">
                <div class="col-md-4 mb-2">
                    <label class="form-label fw-bold text-burgundy">Wine Selection *</label>
                    <select class="form-control wine-select" name="items[${itemCount}][wine_id]" 
                            onchange="updateWineDetails(${itemCount})" required>
                        ${wineOptions}
                    </select>
                    <input type="hidden" name="items[${itemCount}][wine_name]" class="wine-name-input">
                    <input type="hidden" name="items[${itemCount}][wine_category]" class="wine-category-input">
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label fw-bold text-burgundy">Quantity *</label>
                    <input type="number" class="form-control quantity-input" name="items[${itemCount}][quantity]" 
                           min="1" value="1" onchange="calculateTotal()" required>
                    <small class="text-muted stock-info" id="stock-info-${itemCount}"></small>
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label fw-bold text-burgundy">Unit Price</label>
                    <input type="number" class="form-control price-input" name="items[${itemCount}][unit_price]" 
                           step="0.01" min="0" value="0" readonly>
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label fw-bold text-burgundy">Subtotal</label>
                    <input type="text" class="form-control subtotal-input" value="UGX 0" readonly>
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="button" class="btn btn-outline-danger btn-sm d-block w-100" 
                            onclick="removeItem(${itemCount})" title="Remove wine item">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <div class="wine-description mt-2" id="wine-description-${itemCount}"></div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', itemHtml);
    calculateTotal();
}

function updateWineDetails(itemId) {
    const select = document.querySelector(`#item-${itemId} .wine-select`);
    const selectedOption = select.options[select.selectedIndex];
    const wineId = select.value;
    
    if (wineId) {
        const wine = wineItems.find(w => w.id == wineId);
        if (wine) {
            // Update hidden inputs
            document.querySelector(`#item-${itemId} .wine-name-input`).value = wine.name;
            document.querySelector(`#item-${itemId} .wine-category-input`).value = wine.category;
            
            // Update price
            const priceInput = document.querySelector(`#item-${itemId} .price-input`);
            priceInput.value = wine.unit_price;
            
            // Update stock info
            const stockInfo = document.querySelector(`#stock-info-${itemId}`);
            if (wine.quantity > 0) {
                stockInfo.textContent = `Available: ${wine.quantity} bottles`;
                stockInfo.className = 'text-success small';
            } else {
                stockInfo.textContent = 'Out of stock';
                stockInfo.className = 'text-danger small';
            }
            
            // Update description (show only if not null/empty)
            const descriptionDiv = document.querySelector(`#wine-description-${itemId}`);
            if (wine.description) {
                descriptionDiv.innerHTML = `<small class="text-muted"><i class="fas fa-info-circle"></i> ${wine.description}</small>`;
            } else {
                descriptionDiv.innerHTML = '';
            }
        }
    } else {
        // Clear fields if no wine selected
        document.querySelector(`#item-${itemId} .wine-name-input`).value = '';
        document.querySelector(`#item-${itemId} .wine-category-input`).value = '';
        document.querySelector(`#item-${itemId} .price-input`).value = '0';
        document.querySelector(`#stock-info-${itemId}`).textContent = '';
        document.querySelector(`#wine-description-${itemId}`).innerHTML = '';
    }
    
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
        
        subtotalInputs[i].value = `UGX ${subtotal.toFixed(2)}`;
        total += subtotal;
    }

    document.getElementById('totalAmount').textContent = `UGX ${total.toFixed(2)}`;
    document.getElementById('totalAmountInput').value = total.toFixed(2);
}

document.addEventListener('DOMContentLoaded', function() {
    addItem();
});
</script>

@push('styles')
<style>
:root {
    --burgundy: #5e0f0f;
    --gold: #c8a97e;
    --cream: #f5f0e6;
    --light-burgundy: #8b1a1a;
    --dark-gold: #b8945f;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, var(--cream) 0%, #fff 100%);
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(94, 15, 15, 0.1);
}

.page-title {
    margin: 0;
}

.text-burgundy {
    color: var(--burgundy) !important;
}

.text-gold {
    color: var(--gold) !important;
}

.bg-burgundy {
    background-color: var(--burgundy) !important;
}

.bg-gold {
    background-color: var(--gold) !important;
}

.btn-burgundy {
    background-color: var(--burgundy);
    border-color: var(--burgundy);
    color: white;
}

.btn-burgundy:hover {
    background-color: var(--light-burgundy);
    border-color: var(--light-burgundy);
    color: white;
}

.btn-outline-burgundy {
    color: var(--burgundy);
    border-color: var(--burgundy);
}

.btn-outline-burgundy:hover {
    background-color: var(--burgundy);
    border-color: var(--burgundy);
    color: white;
}

.wine-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 12px;
    overflow: hidden;
}

.wine-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(94, 15, 15, 0.15) !important;
}

.wine-list-item {
    transition: background-color 0.2s ease;
    border-radius: 8px;
    margin-bottom: 0.5rem;
    border: 1px solid var(--cream) !important;
}

.wine-list-item:hover {
    background-color: var(--cream);
}

.header-actions .badge {
    border-radius: 20px;
    font-weight: 500;
}

.card-header {
    border-bottom: 2px solid var(--cream);
    background: linear-gradient(135deg, #fff 0%, var(--cream) 100%);
}

.form-control:focus {
    border-color: var(--gold);
    box-shadow: 0 0 0 0.2rem rgba(200, 169, 126, 0.25);
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .header-actions {
        order: -1;
    }
}
</style>
@endpush
@endsection 