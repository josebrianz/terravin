@extends('layouts.admin')

@section('title', 'Order Details - Admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-receipt me-2 text-gold"></i>
                        Order #{{ $order->id }}
                    </h1>
                    <span class="text-muted small">Order details and management</span>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-burgundy">
                        <i class="fas fa-arrow-left"></i> Back to Orders
                    </a>
                    <a href="{{ route('admin.orders.invoice', $order->id) }}" class="btn btn-outline-secondary" target="_blank">
                        <i class="fas fa-file-invoice"></i> Print Invoice
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-user me-2 text-gold"></i> Customer Info
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-2"><span class="fw-bold">Name:</span> {{ $order->customer_name }}</div>
                    <div class="mb-2"><span class="fw-bold">Email:</span> <a href="mailto:{{ $order->customer_email }}">{{ $order->customer_email }}</a> <button type="button" class="btn btn-sm btn-outline-secondary btn-copy" data-copy="{{ $order->customer_email }}" title="Copy Email"><i class="fas fa-copy"></i></button></div>
                    <div class="mb-2"><span class="fw-bold">Phone:</span> <a href="tel:{{ $order->customer_phone }}">{{ $order->customer_phone }}</a> <button type="button" class="btn btn-sm btn-outline-secondary btn-copy" data-copy="{{ $order->customer_phone }}" title="Copy Phone"><i class="fas fa-copy"></i></button></div>
                    <div class="mb-2"><span class="fw-bold">Shipping Address:</span> {{ $order->shipping_address }}</div>
                    <div class="mb-2"><span class="fw-bold">Notes:</span> {{ $order->notes ?? '-' }}</div>
                    <div class="mb-2"><span class="fw-bold">Order Date:</span> {{ $order->created_at->format('M d, Y H:i') }}</div>
                </div>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-sticky-note me-2 text-gold"></i> Internal Admin Notes
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.orders.update-admin-notes', $order->id) }}">
                        @csrf
                        <textarea name="admin_notes" class="form-control mb-2" rows="3" placeholder="Add internal notes for this order...">{{ old('admin_notes', $order->admin_notes) }}</textarea>
                        <button type="submit" class="btn btn-burgundy"><i class="fas fa-save"></i> Save Notes</button>
                    </form>
                </div>
            </div>
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-history me-2 text-gold"></i> Order Audit Log
                    </h5>
                </div>
                <div class="card-body">
                    @if($auditLogs->count())
                        <ul class="list-group mb-0">
                            @foreach($auditLogs as $log)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="fw-bold">{{ $log->user->name ?? 'System' }}</span>
                                            <span class="text-muted small">({{ $log->user->email ?? '-' }})</span>
                                            <span class="badge bg-light text-dark ms-2">{{ $log->action }}</span>
                                        </div>
                                        <span class="text-muted small">{{ $log->created_at->format('M d, Y H:i') }}</span>
                                    </div>
                                    <div class="mt-1">
                                        <span class="text-muted small">Old:</span> <code>{{ json_encode($log->old_values) }}</code><br>
                                        <span class="text-muted small">New:</span> <code>{{ json_encode($log->new_values) }}</code>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-muted">No audit log entries for this order.</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-user-cog me-2 text-gold"></i> Order Assignment
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.orders.update-assignment', $order->id) }}">
                        @csrf
                        <div class="mb-2">
                            <span class="fw-bold">Current Assignee:</span>
                            @if($order->assignedTo)
                                {{ $order->assignedTo->name }} <span class="text-muted small">({{ $order->assignedTo->email }})</span>
                            @else
                                <span class="text-muted">Unassigned</span>
                            @endif
                        </div>
                        <div class="mb-2">
                            <label for="assigned_to" class="form-label">Assign to</label>
                            <select name="assigned_to" id="assigned_to" class="form-select">
                                <option value="">-- Unassigned --</option>
                                @foreach(\App\Models\User::where('role', 'Admin')->get() as $admin)
                                    <option value="{{ $admin->id }}" @if($order->assigned_to == $admin->id) selected @endif>{{ $admin->name }} ({{ $admin->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-burgundy"><i class="fas fa-save"></i> Update Assignment</button>
                    </form>
                </div>
            </div>
            @if($shipment)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-truck me-2 text-gold"></i> Shipment / Tracking Info
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-2"><span class="fw-bold">Tracking #:</span> {{ $shipment->tracking_number ?? '-' }}</div>
                    <div class="mb-2"><span class="fw-bold">Carrier:</span> {{ $shipment->carrier ?? '-' }}</div>
                    <div class="mb-2"><span class="fw-bold">Status:</span> <span class="badge {{ $shipment->status_badge }}">{{ ucfirst($shipment->status) }}</span></div>
                    <div class="mb-2"><span class="fw-bold">Estimated Delivery:</span> {{ $shipment->estimated_delivery_date ? $shipment->estimated_delivery_date->format('M d, Y') : '-' }}</div>
                    <div class="mb-2"><span class="fw-bold">Actual Delivery:</span> {{ $shipment->actual_delivery_date ? $shipment->actual_delivery_date->format('M d, Y') : '-' }}</div>
                    @if($shipment->tracking_number && $shipment->carrier)
                        <div class="mb-2">
                            <a href="https://track.aftership.com/{{ strtolower($shipment->carrier) }}/{{ $shipment->tracking_number }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-external-link-alt"></i> Track Shipment
                            </a>
                        </div>
                    @endif
                    <div class="mb-2"><span class="fw-bold">Notes:</span> {{ $shipment->notes ?? '-' }}</div>
                </div>
            </div>
            @endif
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-cogs me-2 text-gold"></i> Manage Status
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.orders.update-status', $order->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="status" class="form-label fw-bold text-burgundy">Order Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="pending" @if($order->status=='pending') selected @endif>Pending</option>
                                <option value="processing" @if($order->status=='processing') selected @endif>Processing</option>
                                <option value="shipped" @if($order->status=='shipped') selected @endif>Shipped</option>
                                <option value="delivered" @if($order->status=='delivered') selected @endif>Delivered</option>
                                <option value="cancelled" @if($order->status=='cancelled') selected @endif>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-burgundy">
                            <i class="fas fa-save"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-boxes me-2 text-gold"></i> Order Items
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Image</th>
                                    <th>Item</th>
                                    <th>Unit Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td><img src="{{ $item->item_image }}" alt="{{ $item->item_name }}" style="width:40px;height:60px;object-fit:cover;border-radius:4px;"></td>
                                    <td>{{ $item->item_name }}</td>
                                    <td>{{ format_usd($item->unit_price) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ format_usd($item->subtotal) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white d-flex justify-content-end">
                    <span class="fw-bold text-burgundy fs-5">Total: {{ format_usd($order->total_amount) }}</span>
                </div>
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
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-copy').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const value = btn.getAttribute('data-copy');
            navigator.clipboard.writeText(value);
            btn.classList.remove('btn-outline-secondary');
            btn.classList.add('btn-success');
            setTimeout(() => {
                btn.classList.remove('btn-success');
                btn.classList.add('btn-outline-secondary');
            }, 1000);
        });
    });
});
</script>
@endpush
@endsection 