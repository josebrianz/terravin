@extends('layouts.admin')

@section('title', 'All Shipments')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="page-title fw-bold text-burgundy">
                <i class="fas fa-truck me-2 text-gold"></i> All Shipments
            </h1>
            <a href="{{ route('shipments.create') }}" class="btn btn-gold">
                <i class="fas fa-plus"></i> Create Shipment
            </a>
        </div>
    </div>
    <div class="card border-0 shadow-sm wine-card">
        <div class="card-header bg-white border-bottom-0">
            <h5 class="card-title mb-0 fw-bold text-burgundy">
                <i class="fas fa-list text-gold me-2"></i> Shipments List
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Tracking #</th>
                            <th>Status</th>
                            <th>Carrier</th>
                            <th>Estimated Delivery</th>
                            <th>Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($shipments as $shipment)
                        <tr>
                            <td>{{ $shipment->tracking_number ?? 'N/A' }}</td>
                            <td><span class="badge {{ $shipment->status_badge }}">{{ ucfirst($shipment->status) }}</span></td>
                            <td>{{ $shipment->carrier ?? '-' }}</td>
                            <td>{{ $shipment->estimated_delivery_date ? $shipment->estimated_delivery_date->format('M d, Y') : '-' }}</td>
                            <td>{{ $shipment->order ? $shipment->order->order_number ?? $shipment->order->id : '-' }}</td>
                            <td>
                                <a href="{{ route('shipments.show', $shipment) }}" class="btn btn-sm btn-outline-burgundy">View</a>
                                <a href="{{ route('shipments.edit', $shipment) }}" class="btn btn-sm btn-outline-gold">Edit</a>
                                <form action="{{ route('shipments.destroy', $shipment) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this shipment?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No shipments found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $shipments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 