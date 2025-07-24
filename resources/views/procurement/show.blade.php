@extends('layouts.plain')

@section('title', 'Wine Supply Order Details')

@section('content')
    @include('layouts.navigation')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="page-header mb-4">
                <h1 class="page-title">
                    <i class="fas fa-wine-bottle"></i>
                    Wine Supply Order Details
                </h1>
                <div class="page-options">
                    <a href="{{ route('procurement.index') }}" class="btn btn-burgundy btn-lg rounded-pill me-2">
                        <i class="fas fa-arrow-left"></i> Back to Supply Orders
                    </a>
                    <a href="{{ route('procurement.edit', $procurement) }}" class="btn btn-outline-burgundy btn-lg rounded-pill">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <!-- Main Information -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle"></i> Wine Supply Order Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold">PO Number:</td>
                                            <td>{{ $procurement->po_number }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Supply Item:</td>
                                            <td>{{ $procurement->item_name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Description:</td>
                                            <td>{{ $procurement->description ?: 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Quantity:</td>
                                            <td>{{ $procurement->quantity }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Unit Price:</td>
                                            <td>${{ number_format($procurement->unit_price, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Total Amount:</td>
                                            <td class="h5 text-primary">${{ number_format($procurement->total_amount, 2) }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold">Status:</td>
                                            <td>
                                                <span class="badge {{ $procurement->status_badge_class }} fs-6">
                                                    {{ ucfirst($procurement->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Created Date:</td>
                                            <td>{{ $procurement->created_at->format('M d, Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Requested By:</td>
                                            <td>{{ $procurement->requester->name ?? 'N/A' }}</td>
                                        </tr>
                                        @if($procurement->approved_by)
                                        <tr>
                                            <td class="fw-bold">Approved By:</td>
                                            <td>{{ $procurement->approver->name ?? 'N/A' }}</td>
                                        </tr>
                                        @endif
                                        @if($procurement->order_date)
                                        <tr>
                                            <td class="fw-bold">Order Date:</td>
                                            <td>{{ $procurement->order_date->format('M d, Y') }}</td>
                                        </tr>
                                        @endif
                                        @if($procurement->expected_delivery)
                                        <tr>
                                            <td class="fw-bold">Expected Delivery:</td>
                                            <td>{{ $procurement->expected_delivery->format('M d, Y') }}</td>
                                        </tr>
                                        @endif
                                        @if($procurement->actual_delivery)
                                        <tr>
                                            <td class="fw-bold">Actual Delivery:</td>
                                            <td>{{ $procurement->actual_delivery->format('M d, Y') }}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Supplier Information -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-building"></i> Wine Supply Supplier Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Supplier Name:</strong><br>
                                    {{ $procurement->wholesaler_name }}
                                </div>
                                <div class="col-md-4">
                                    <strong>Email:</strong><br>
                                    {{ $procurement->wholesaler_email ?: 'N/A' }}
                                </div>
                                <div class="col-md-4">
                                    <strong>Phone:</strong><br>
                                    {{ $procurement->wholesaler_phone ?: 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($procurement->notes)
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-sticky-note"></i> Notes
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $procurement->notes }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Status Actions -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-cogs"></i> Supply Order Actions
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($procurement->status === 'pending')
                                <form action="{{ route('procurement.approve', $procurement) }}" method="POST" class="mb-2">
                                    @csrf
                                    <button type="submit" class="btn btn-burgundy btn-lg btn-block w-100 rounded-pill mb-2" 
                                            onclick="return confirm('Approve this wine supply order?')">
                                        <i class="fas fa-check"></i> Approve Supply Order
                                    </button>
                                </form>
                            @endif

                            @if($procurement->status === 'approved')
                                <form action="{{ route('procurement.markAsOrdered', $procurement) }}" method="POST" class="mb-2">
                                    @csrf
                                    <button type="submit" class="btn btn-burgundy btn-lg btn-block w-100 rounded-pill mb-2" 
                                            onclick="return confirm('Mark as ordered?')">
                                        <i class="fas fa-truck"></i> Mark as Ordered
                                    </button>
                                </form>
                            @endif

                            @if($procurement->status === 'ordered')
                                <form action="{{ route('procurement.markAsReceived', $procurement) }}" method="POST" class="mb-2">
                                    @csrf
                                    <button type="submit" class="btn btn-burgundy btn-lg btn-block w-100 rounded-pill mb-2" 
                                            onclick="return confirm('Mark as received?')">
                                        <i class="fas fa-box"></i> Mark as Received
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('procurement.edit', $procurement) }}" class="btn btn-outline-burgundy btn-lg btn-block w-100 rounded-pill mb-2">
                                <i class="fas fa-edit"></i> Edit Supply Order
                            </a>

                            <form action="{{ route('procurement.destroy', $procurement) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-burgundy btn-lg btn-block w-100 rounded-pill mb-2" 
                                        onclick="return confirm('Are you sure you want to delete this order?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Status Timeline -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-history"></i> Supply Order Timeline
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <div class="timeline-item {{ $procurement->status === 'pending' || $procurement->status === 'approved' || $procurement->status === 'ordered' || $procurement->status === 'received' ? 'active' : '' }}">
                                    <div class="timeline-marker bg-warning"></div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">Pending</h6>
                                        <p class="timeline-text">Supply request submitted</p>
                                        <small class="text-muted">{{ $procurement->created_at->format('M d, Y') }}</small>
                                    </div>
                                </div>

                                <div class="timeline-item {{ $procurement->status === 'approved' || $procurement->status === 'ordered' || $procurement->status === 'received' ? 'active' : '' }}">
                                    <div class="timeline-marker bg-info"></div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">Approved</h6>
                                        <p class="timeline-text">Supply request approved</p>
                                        @if($procurement->approved_by)
                                            <small class="text-muted">By: {{ $procurement->approver->name ?? 'N/A' }}</small>
                                        @endif
                                    </div>
                                </div>

                                <div class="timeline-item {{ $procurement->status === 'ordered' || $procurement->status === 'received' ? 'active' : '' }}">
                                    <div class="timeline-marker bg-primary"></div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">Ordered</h6>
                                        <p class="timeline-text">Order placed with supplier</p>
                                        @if($procurement->order_date)
                                            <small class="text-muted">{{ $procurement->order_date->format('M d, Y') }}</small>
                                        @endif
                                    </div>
                                </div>

                                <div class="timeline-item {{ $procurement->status === 'received' ? 'active' : '' }}">
                                    <div class="timeline-marker bg-success"></div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">Received</h6>
                                        <p class="timeline-text">Wine supplies received</p>
                                        @if($procurement->actual_delivery)
                                            <small class="text-muted">{{ $procurement->actual_delivery->format('M d, Y') }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.page-title {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 600;
}

.page-options {
    display: flex;
    gap: 0.5rem;
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
    opacity: 0.5;
}

.timeline-item.active {
    opacity: 1;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-item.active .timeline-marker {
    box-shadow: 0 0 0 2px #007bff;
}

.timeline-content {
    padding-left: 10px;
}

.timeline-title {
    margin: 0;
    font-size: 0.9rem;
    font-weight: 600;
}

.timeline-text {
    margin: 0;
    font-size: 0.8rem;
    color: #6c757d;
}

.btn-block {
    display: block;
    width: 100%;
}

.btn-burgundy, .btn-outline-burgundy {
    box-shadow: 0 4px 18px 0 rgba(200, 169, 126, 0.25), 0 1.5px 0 0 var(--gold);
    border-width: 2.5px !important;
    border-color: var(--gold) !important;
    position: relative;
    overflow: hidden;
    transition: box-shadow 0.25s cubic-bezier(0.4,0,0.2,1),
                transform 0.18s cubic-bezier(0.4,0,0.2,1),
                border-color 0.18s cubic-bezier(0.4,0,0.2,1);
}
.btn-burgundy:hover, .btn-burgundy:focus,
.btn-outline-burgundy:hover, .btn-outline-burgundy:focus {
    box-shadow: 0 8px 32px 0 rgba(200, 169, 126, 0.38), 0 2.5px 0 0 var(--gold);
    border-color: var(--gold) !important;
    transform: scale(1.045);
}
.btn-burgundy::after, .btn-outline-burgundy::after {
    content: '';
    position: absolute;
    left: -75%;
    top: 0;
    width: 50%;
    height: 100%;
    background: linear-gradient(120deg, rgba(200,169,126,0.18) 0%, rgba(255,255,255,0.12) 100%);
    transform: skewX(-25deg);
    transition: left 0.4s cubic-bezier(0.4,0,0.2,1);
    pointer-events: none;
    z-index: 1;
}
.btn-burgundy:hover::after, .btn-burgundy:focus::after,
.btn-outline-burgundy:hover::after, .btn-outline-burgundy:focus::after {
    left: 120%;
}
.btn-burgundy i, .btn-outline-burgundy i {
    color: var(--gold) !important;
    filter: drop-shadow(0 1px 0 #fff7e0);
}
</style>
@endpush
@endsection 