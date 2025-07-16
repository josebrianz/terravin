@extends('layouts.admin')

@section('title', 'Create Shipment')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="page-title fw-bold text-burgundy">
                <i class="fas fa-truck me-2 text-gold"></i> Create Shipment
            </h1>
        </div>
    </div>
    <div class="card border-0 shadow-sm wine-card">
        <div class="card-header bg-white border-bottom-0">
            <h5 class="card-title mb-0 fw-bold text-burgundy">
                <i class="fas fa-plus text-gold me-2"></i> New Shipment
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('shipments.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="order_id" class="form-label fw-bold">Order</label>
                        <select name="order_id" id="order_id" class="form-select" required>
                            <option value="">Select Order</option>
                            @foreach($orders as $order)
                                <option value="{{ $order->id }}">#{{ $order->order_number ?? $order->id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="tracking_number" class="form-label fw-bold">Tracking Number</label>
                        <input type="text" name="tracking_number" id="tracking_number" class="form-control" value="{{ old('tracking_number') }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="status" class="form-label fw-bold">Status</label>
                        <select name="status" id="status" class="form-select" required>
                            @foreach(\App\Models\Shipment::getStatusOptions() as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="carrier" class="form-label fw-bold">Carrier</label>
                        <select name="carrier" id="carrier" class="form-select">
                            <option value="">Select Carrier</option>
                            @foreach(\App\Models\Shipment::getCarrierOptions() as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="shipping_cost" class="form-label fw-bold">Shipping Cost</label>
                        <input type="number" step="0.01" name="shipping_cost" id="shipping_cost" class="form-control" value="{{ old('shipping_cost') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="estimated_delivery_date" class="form-label fw-bold">Estimated Delivery Date</label>
                        <input type="date" name="estimated_delivery_date" id="estimated_delivery_date" class="form-control" value="{{ old('estimated_delivery_date') }}">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="shipping_address" class="form-label fw-bold">Shipping Address</label>
                    <textarea name="shipping_address" id="shipping_address" class="form-control" rows="2">{{ old('shipping_address') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="notes" class="form-label fw-bold">Notes</label>
                    <textarea name="notes" id="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                </div>
                <div class="text-end">
                    <a href="{{ route('shipments.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-gold">Create Shipment</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 