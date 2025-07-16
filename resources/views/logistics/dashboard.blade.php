@extends('layouts.admin')

@section('title', 'Logistics Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-truck me-2 text-gold"></i>
                        Logistics Dashboard
                    </h1>
                    <span class="text-muted small">Overview of all wine shipments and deliveries</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-3 text-center">
            <div class="stat-item">
                <div class="stat-icon bg-burgundy">
                    <i class="fas fa-truck fa-2x text-gold"></i>
                </div>
                <h4 class="text-burgundy fw-bold mt-2">{{ $total }}</h4>
                <span class="text-muted small">Total Shipments</span>
            </div>
        </div>
        <div class="col-md-3 text-center">
            <div class="stat-item">
                <div class="stat-icon bg-gold">
                    <i class="fas fa-clock fa-2x text-burgundy"></i>
                </div>
                <h4 class="text-burgundy fw-bold mt-2">{{ $pending }}</h4>
                <span class="text-muted small">Pending</span>
            </div>
        </div>
        <div class="col-md-3 text-center">
            <div class="stat-item">
                <div class="stat-icon bg-warning">
                    <i class="fas fa-shipping-fast fa-2x text-white"></i>
                </div>
                <h4 class="text-burgundy fw-bold mt-2">{{ $inTransit }}</h4>
                <span class="text-muted small">In Transit</span>
            </div>
        </div>
        <div class="col-md-3 text-center">
            <div class="stat-item">
                <div class="stat-icon bg-success">
                    <i class="fas fa-check fa-2x text-white"></i>
                </div>
                <h4 class="text-burgundy fw-bold mt-2">{{ $delivered }}</h4>
                <span class="text-muted small">Delivered</span>
            </div>
        </div>
    </div>
    <div class="card border-0 shadow-sm wine-card">
        <div class="card-header bg-white border-bottom-0">
            <h5 class="card-title mb-0 fw-bold text-burgundy">
                <i class="fas fa-list text-gold me-2"></i> Recent Shipments
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
                        @forelse($recent as $shipment)
                        <tr>
                            <td>{{ $shipment->tracking_number ?? 'N/A' }}</td>
                            <td><span class="badge {{ $shipment->status_badge }}">{{ ucfirst($shipment->status) }}</span></td>
                            <td>{{ $shipment->carrier ?? '-' }}</td>
                            <td>{{ $shipment->estimated_delivery_date ? $shipment->estimated_delivery_date->format('M d, Y') : '-' }}</td>
                            <td>{{ $shipment->order ? $shipment->order->order_number ?? $shipment->order->id : '-' }}</td>
                            <td>
                                <a href="{{ route('shipments.show', $shipment) }}" class="btn btn-sm btn-outline-burgundy">View</a>
                                <a href="{{ route('shipments.edit', $shipment) }}" class="btn btn-sm btn-outline-gold">Edit</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No recent shipments.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3 text-end">
                <a href="{{ route('shipments.index') }}" class="btn btn-burgundy">View All Shipments</a>
                <a href="{{ route('shipments.create') }}" class="btn btn-gold">Create Shipment</a>
            </div>
        </div>
    </div>
</div>
@endsection 