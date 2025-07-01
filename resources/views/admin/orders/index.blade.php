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
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
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