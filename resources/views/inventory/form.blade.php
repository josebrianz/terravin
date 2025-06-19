<div class="mb-3">
    <label>Item Name</label>
    <input type="text" name="item_name" class="form-control" value="{{ old('item_name', $item->item_name ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Item Code</label>
    <input type="text" name="item_code" class="form-control" value="{{ old('item_code', $item->item_code ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Quantity</label>
    <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $item->quantity ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Price</label>
    <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $item->price ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Location</label>
    <input type="text" name="location" class="form-control" value="{{ old('location', $item->location ?? '') }}">
</div>
