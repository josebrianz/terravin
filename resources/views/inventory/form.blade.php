<div class="mb-3">
    <label class="form-label fw-bold text-burgundy">Wine Name *</label>
    <input type="text" name="item_name" class="form-control" 
           value="{{ old('item_name', $item->item_name ?? '') }}" 
           placeholder="e.g., Cabernet Sauvignon 2020" required>
</div>

<div class="mb-3">
    <label class="form-label fw-bold text-burgundy">Item Code *</label>
    <input type="text" name="item_code" class="form-control" 
           value="{{ old('item_code', $item->item_code ?? '') }}" 
           placeholder="e.g., CAB-2020-001" required>
</div>

<div class="mb-3">
    <label class="form-label fw-bold text-burgundy">Quantity (Bottles) *</label>
    <input type="number" name="quantity" class="form-control" 
           value="{{ old('quantity', $item->quantity ?? '') }}" 
           min="0" placeholder="Number of bottles" required>
</div>

<div class="mb-3">
    <label class="form-label fw-bold text-burgundy">Price per Bottle *</label>
    <div class="input-group">
        <span class="input-group-text text-burgundy">UGX</span>
        <input type="number" step="0.01" name="price" class="form-control" 
               value="{{ old('price', $item->price ?? '') }}" 
               min="0" placeholder="0.00" required>
    </div>
</div>

<div class="mb-3">
    <label class="form-label fw-bold text-burgundy">Storage Location</label>
    <input type="text" name="location" class="form-control" 
           value="{{ old('location', $item->location ?? '') }}" 
           placeholder="e.g., Cellar A, Rack 3">
</div>
