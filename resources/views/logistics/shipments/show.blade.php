@extends('layouts.admin')

@section('title', 'Shipment Details')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="page-title fw-bold text-burgundy">
                <i class="fas fa-truck me-2 text-gold"></i> Shipment Details
            </h1>
            <div>
                <a href="{{ route('shipments.edit', $shipment) }}" class="btn btn-gold me-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('shipments.destroy', $shipment) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this shipment?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
    <div class="card border-0 shadow-sm wine-card">
        <div class="card-header bg-white border-bottom-0">
            <h5 class="card-title mb-0 fw-bold text-burgundy">
                <i class="fas fa-info-circle text-gold me-2"></i> Shipment Information
            </h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Tracking Number:</strong> {{ $shipment->tracking_number ?? 'N/A' }}
                </div>
                <div class="col-md-6">
                    <strong>Status:</strong> <span class="badge {{ $shipment->status_badge }}">{{ ucfirst($shipment->status) }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Carrier:</strong> {{ $shipment->carrier ?? '-' }}
                </div>
                <div class="col-md-6">
                    <strong>Shipping Cost:</strong> {{ $shipment->shipping_cost ? number_format($shipment->shipping_cost, 2) : '-' }}
                </div>
            </div>
            @php
                use Illuminate\Support\Carbon;
                $estDate = $shipment->estimated_delivery_date;
                if ($estDate && !($estDate instanceof \Illuminate\Support\Carbon)) {
                    $estDate = Carbon::parse($estDate);
                }
                $actDate = $shipment->actual_delivery_date;
                if ($actDate && !($actDate instanceof \Illuminate\Support\Carbon)) {
                    $actDate = Carbon::parse($actDate);
                }
            @endphp
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Estimated Delivery Date:</strong> {{ $estDate ? $estDate->format('M d, Y') : '-' }}
                </div>
                <div class="col-md-6">
                    <strong>Actual Delivery Date:</strong> {{ $actDate ? $actDate->format('M d, Y') : '-' }}
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Order:</strong> {{ $shipment->order ? ($shipment->order->order_number ?? $shipment->order->id) : '-' }}
                </div>
                <div class="col-md-6">
                    <strong>Shipping Address:</strong> {{ $shipment->shipping_address ?? '-' }}
                </div>
            </div>
            <div class="mb-3">
                <strong>Notes:</strong> {{ $shipment->notes ?? '-' }}
            </div>
        </div>
    </div>
    <div class="mt-4">
        <a href="{{ route('shipments.index') }}" class="btn btn-secondary">Back to Shipments</a>
    </div>
</div>
@endsection 