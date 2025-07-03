@extends('layouts.admin')

@section('title', 'Wine Supply Orders')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-wine-bottle me-2 text-gold"></i>
                        Wine Supply Orders
                    </h1>
                    <span class="text-muted small">All wine supply procurement requests and their statuses</span>
                </div>
                <div class="header-actions">
                    <a href="{{ route('procurement.create') }}" class="btn btn-burgundy shadow-sm" title="New Supply Request">
                        <i class="fas fa-plus"></i> New Supply Request
                    </a>
                    <a href="{{ route('procurement.dashboard') }}" class="btn btn-gold ms-2 shadow-sm" title="Dashboard">
                        <i class="fas fa-chart-bar"></i> Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-body">
                    <form method="GET" action="{{ route('procurement.index') }}" class="row">
                        <div class="col-md-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="ordered" {{ request('status') == 'ordered' ? 'selected' : '' }}>On Order</option>
                                <option value="received" {{ request('status') == 'received' ? 'selected' : '' }}>Received</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="supplier" class="form-label">Supplier</label>
                            <input type="text" name="supplier" id="supplier" class="form-control" 
                                   value="{{ request('supplier') }}" placeholder="Search supplier...">
                        </div>
                        <div class="col-md-3">
                            <label for="date_from" class="form-label">Date From</label>
                            <input type="date" name="date_from" id="date_from" class="form-control" 
                                   value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="date_to" class="form-label">Date To</label>
                            <input type="date" name="date_to" id="date_to" class="form-control" 
                                   value="{{ request('date_to') }}">
                        </div>
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Filter
                            </button>
                            <a href="{{ route('procurement.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Supply Orders Table -->
    <div class="row">
        <div class="col-12">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-list text-gold me-2"></i> Wine Supply Orders
                    </h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>PO Number</th>
                                    <th>Supply Item</th>
                                    <th>Supplier</th>
                                    <th>Quantity</th>
                                    <th>Unit Price (UGX)</th>
                                    <th>Total Amount (UGX)</th>
                                    <th>Status</th>
                                    <th>Requested By</th>
                                    <th>Created Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($procurements as $procurement)
                                <tr>
                                    <td>
                                        <a href="{{ route('procurement.show', $procurement) }}" class="text-primary fw-bold">
                                            {{ $procurement->po_number }}
                                        </a>
                                    </td>
                                    <td>{{ $procurement->item_name }}</td>
                                    <td>{{ $procurement->supplier_name }}</td>
                                    <td>{{ $procurement->quantity }}</td>
                                    <td>UGX {{ number_format($procurement->unit_price, 0) }}</td>
                                    <td>UGX {{ number_format($procurement->total_amount, 0) }}</td>
                                    <td>
                                        <span class="badge {{ $procurement->status_badge_class }}">
                                            {{ ucfirst($procurement->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $procurement->requester->name ?? 'N/A' }}</td>
                                    <td>{{ $procurement->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('procurement.show', $procurement) }}" 
                                               class="btn btn-sm btn-outline-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('procurement.edit', $procurement) }}" 
                                               class="btn btn-sm btn-outline-secondary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            @if($procurement->status === 'pending')
                                            <form action="{{ route('procurement.approve', $procurement) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success" 
                                                        title="Approve" onclick="return confirm('Approve this supply order?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            @endif
                                            
                                            @if($procurement->status === 'approved')
                                            <form action="{{ route('procurement.markAsOrdered', $procurement) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-info" 
                                                        title="Mark as Ordered" onclick="return confirm('Mark as ordered?')">
                                                    <i class="fas fa-truck"></i>
                                                </button>
                                            </form>
                                            @endif
                                            
                                            @if($procurement->status === 'ordered')
                                            <form action="{{ route('procurement.markAsReceived', $procurement) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success" 
                                                        title="Mark as Received" onclick="return confirm('Mark as received?')">
                                                    <i class="fas fa-box"></i>
                                                </button>
                                            </form>
                                            @endif
                                            
                                            <form action="{{ route('procurement.destroy', $procurement) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                        title="Delete" onclick="return confirm('Are you sure you want to delete this supply order?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-wine-bottle fa-3x mb-3"></i>
                                            <p>No wine supply orders found</p>
                                            <a href="{{ route('procurement.create') }}" class="btn btn-primary">
                                                Create First Supply Order
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($procurements->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $procurements->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
:root {
    --burgundy: #5e0f0f;
    --gold: #c8a97e;
    --cream: #f5f0e6;
    --light-burgundy: #8b1a1a;
    --dark-gold: #b8945f;
}
.wine-card {
    background: var(--cream);
    border-radius: 16px;
    border: 1px solid var(--gold);
    box-shadow: 0 4px 24px rgba(94, 15, 15, 0.07);
}
.card-body {
    background: var(--cream);
    border-radius: 16px;
}
.form-label {
    color: var(--burgundy);
    font-weight: 600;
}
input.form-control, textarea.form-control, select.form-control {
    border: 1px solid var(--gold);
    border-radius: 8px;
    background: #fff8f3;
    color: var(--burgundy);
}
input.form-control:focus, textarea.form-control:focus, select.form-control:focus {
    border-color: var(--burgundy);
    box-shadow: 0 0 0 2px var(--gold);
    background: #fff8f3;
    color: var(--burgundy);
}
.btn-burgundy {
    background: var(--burgundy);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    transition: background 0.2s;
}
.btn-burgundy:hover, .btn-burgundy:focus {
    background: var(--light-burgundy);
    color: #fff;
}
.btn-gold {
    background: var(--gold);
    color: var(--burgundy);
    border: none;
    border-radius: 8px;
    font-weight: 600;
    transition: background 0.2s;
}
.btn-gold:hover, .btn-gold:focus {
    background: var(--dark-gold);
    color: #fff;
}
.btn-primary {
    background: var(--gold);
    color: var(--burgundy);
    border: none;
    border-radius: 8px;
    font-weight: 600;
    transition: background 0.2s;
}
.btn-primary:hover, .btn-primary:focus {
    background: var(--dark-gold);
    color: #fff;
}
.btn-secondary {
    background: #fff;
    color: var(--burgundy);
    border: 1px solid var(--gold);
    border-radius: 8px;
    font-weight: 600;
    transition: background 0.2s;
}
.btn-secondary:hover, .btn-secondary:focus {
    background: var(--gold);
    color: #fff;
}
.alert-info {
    background: #f8f5f0;
    border-color: var(--gold);
    color: var(--burgundy);
}
.page-header, .card-title, .header-actions {
    color: var(--burgundy);
}
.table thead th {
    color: var(--burgundy);
    font-weight: 700;
    background: #f8f5f0;
    border-bottom: 2px solid var(--gold);
}
.table-striped > tbody > tr:nth-of-type(odd) {
    background-color: #f5f0e6;
}
.table-hover > tbody > tr:hover {
    background-color: #f9e9e0;
}
</style>
@endpush
@endsection 