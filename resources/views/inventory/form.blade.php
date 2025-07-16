<div class="mb-3">
    <label class="form-label fw-bold text-burgundy">Wine Name *</label>
    <input type="text" name="name" class="form-control" 
           value="{{ old('name', $item->name ?? '') }}" 
           placeholder="e.g., Cabernet Sauvignon 2020" required>
</div>

<div class="mb-3">
    <label class="form-label fw-bold text-burgundy">Item Code *</label>
    <input type="text" name="sku" class="form-control" 
           value="{{ old('sku', $item->sku ?? '') }}" 
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
        <span class="input-group-text text-burgundy">$</span>
        <input type="number" step="0.01" name="unit_price" class="form-control" 
               value="{{ old('unit_price', $item->unit_price ?? '') }}" 
               min="0" placeholder="0.00" required>
    </div>
</div>

<div class="mb-3">
    <label class="form-label fw-bold text-burgundy">Storage Location</label>
    <input type="text" name="location" class="form-control" 
           value="{{ old('location', $item->location ?? '') }}" 
           placeholder="e.g., Cellar A, Rack 3">
</div>

<div class="mb-3">
    <label class="form-label fw-bold text-burgundy">Images</label>
    <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
    @if(isset($item) && !empty($item->images))
        <div class="mt-2">
            <div class="d-flex flex-wrap gap-3">
                @foreach($item->images as $img)
                    <img src="{{ asset('storage/' . $img) }}" alt="Image" style="width: 140px; height: 140px; object-fit: cover; border-radius: 10px; border: 2px solid #800020; box-shadow: 0 4px 16px rgba(128,0,32,0.15); transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='scale(1.05)';this.style.boxShadow='0 8px 24px rgba(128,0,32,0.25)';" onmouseout="this.style.transform='scale(1)';this.style.boxShadow='0 4px 16px rgba(128,0,32,0.15)';">
                @endforeach
            </div>
        </div>
    @endif
</div>
