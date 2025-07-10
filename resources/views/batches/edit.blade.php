@extends('layouts.app')

@section('title', 'Edit Batch')

@section('content')
<div class="container py-4 wine-theme-bg min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h4 class="fw-bold text-burgundy mb-0">Edit Batch</h4>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('batches.update', $batch) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="batch_number" class="form-label fw-bold">Batch Number</label>
                            <input type="text" class="form-control" id="batch_number" name="batch_number" value="{{ old('batch_number', $batch->batch_number) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="product_id" class="form-label fw-bold">Product</label>
                            <select class="form-select" id="product_id" name="product_id" required>
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id', $batch->product_id) == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label fw-bold">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', $batch->quantity) }}" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="manufacture_date" class="form-label fw-bold">Manufacture Date</label>
                            <input type="date" class="form-control" id="manufacture_date" name="manufacture_date" value="{{ old('manufacture_date', $batch->manufacture_date->format('Y-m-d')) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="expiry_date" class="form-label fw-bold">Expiry Date</label>
                            <input type="date" class="form-control" id="expiry_date" name="expiry_date" value="{{ old('expiry_date', optional($batch->expiry_date)->format('Y-m-d')) }}">
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('batches.index') }}" class="btn btn-outline-burgundy me-2">Cancel</a>
                            <button type="submit" class="btn btn-gold">Update Batch</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 