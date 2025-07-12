@extends('layouts.admin')

@section('title', 'Manage Orders - Admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-clipboard-list me-2 text-gold"></i>
                        Manage Orders
                    </h1>
                    <span class="text-muted small">View and manage all customer orders</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All</option>
                        <option value="pending" @if(request('status')=='pending') selected @endif>Pending</option>
                        <option value="processing" @if(request('status')=='processing') selected @endif>Processing</option>
                        <option value="shipped" @if(request('status')=='shipped') selected @endif>Shipped</option>
                        <option value="delivered" @if(request('status')=='delivered') selected @endif>Delivered</option>
                        <option value="cancelled" @if(request('status')=='cancelled') selected @endif>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Customer Name</label>
                    <input type="text" name="customer_name" class="form-control" value="{{ request('customer_name') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Email</label>
                    <input type="text" name="customer_email" class="form-control" value="{{ request('customer_email') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Date From</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Date To</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-1">
                    <label class="form-label">Min Amount</label>
                    <input type="number" name="min_amount" class="form-control" value="{{ request('min_amount') }}" min="0">
                </div>
                <div class="col-md-1">
                    <label class="form-label">Max Amount</label>
                    <input type="number" name="max_amount" class="form-control" value="{{ request('max_amount') }}" min="0">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-burgundy w-100"><i class="fas fa-search"></i> Filter</button>
                </div>
                <div class="col-md-1">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12 d-flex justify-content-between align-items-end">
            <form id="bulk-action-form" method="POST" action="{{ route('admin.orders.bulk') }}" class="d-flex align-items-end gap-2">
                @csrf
                <select name="action" class="form-select w-auto" required>
                    <option value="">Bulk Action</option>
                    <option value="update_status">Update Status</option>
                    <option value="delete">Delete</option>
                </select>
                <select name="status" class="form-select w-auto d-none" id="bulk-status-select">
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="shipped">Shipped</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>
                </select>
                <button type="submit" class="btn btn-burgundy">Apply</button>
            </form>
            <form method="GET" action="{{ route('admin.orders.export') }}" class="d-flex gap-2">
                @foreach(request()->except(['page']) as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-file-export"></i> Export
                    </button>
                    <ul class="dropdown-menu">
                        <li><button class="dropdown-item" type="submit" name="format" value="csv">Export as CSV</button></li>
                        <li><button class="dropdown-item" type="submit" name="format" value="xlsx">Export as Excel</button></li>
                    </ul>
                </div>
            </form>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const actionSelect = document.querySelector('select[name="action"]');
        const statusSelect = document.getElementById('bulk-status-select');
        actionSelect.addEventListener('change', function() {
            if (this.value === 'update_status') {
                statusSelect.classList.remove('d-none');
                statusSelect.required = true;
            } else {
                statusSelect.classList.add('d-none');
                statusSelect.required = false;
            }
        });
    });
    </script>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th><input type="checkbox" id="select-all-orders"></th>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Total (UGX)</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td><input type="checkbox" name="order_ids[]" value="{{ $order->id }}" form="bulk-action-form"></td>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->customer_name }}</td>
                                    <td>{{ $order->customer_email }}</td>
                                    <td>
                                        <span class="badge bg-info text-dark">{{ ucfirst($order->status) }}</span>
                                    </td>
                                    <td>{{ number_format($order->total_amount) }}</td>
                                    <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-burgundy me-1">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this order?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-clipboard-list fa-2x mb-2"></i><br>
                                        No orders found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($orders->hasPages())
                <div class="card-footer bg-white py-3">
                    {{ $orders->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@push('styles')
<style>
.text-burgundy { color: #5e0f0f !important; }
.btn-burgundy { background-color: #5e0f0f; border-color: #5e0f0f; color: white; }
.btn-burgundy:hover { background-color: #8b1a1a; border-color: #8b1a1a; color: white; }
</style>
@endpush
@endsection 