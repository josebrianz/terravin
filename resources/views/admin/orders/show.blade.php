@extends('layouts.admin')

@section('title', 'Order Details - Admin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-clipboard-list me-2 text-gold"></i>
                        Order Details
                    </h1>
                    <span class="text-muted small">Order #{{ $order->id }} - {{ $order->customer_name }}</span>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-outline-gold me-2">
                        <i class="fas fa-edit me-1"></i> Edit Order
                    </a>
                    <a href="{{ route('admin.orders.invoice', $order) }}" class="btn btn-outline-burgundy me-2">
                        <i class="fas fa-file-invoice me-1"></i> Generate Invoice
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Orders
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Order Details -->
        <div class="col-lg-8">
            <div class="card wine-card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-info-circle text-gold me-2"></i> Order Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Order ID</label>
                                <div class="fw-bold text-burgundy">#{{ $order->id }}</div>
                </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Order Date</label>
                                <div>{{ $order->created_at->format('M d, Y') }}</div>
            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Status</label>
                                <div>
                                    @switch($order->status)
                                        @case('pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                            @break
                                        @case('processing')
                                            <span class="badge bg-info text-white">Processing</span>
                                            @break
                                        @case('shipped')
                                            <span class="badge bg-primary text-white">Shipped</span>
                                            @break
                                        @case('delivered')
                                            <span class="badge bg-success text-white">Delivered</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge bg-danger text-white">Cancelled</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary text-white">{{ ucfirst($order->status) }}</span>
                                    @endswitch
                </div>
            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Payment Method</label>
                                <div>{{ $order->payment_method }}</div>
                </div>
            </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Total Amount</label>
                                <div class="fw-bold text-success fs-4">${{ number_format($order->total_amount, 2) }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Last Updated</label>
                                <div>{{ $order->updated_at->format('M d, Y') }}</div>
        </div>
                            @if($order->admin_notes)
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Admin Notes</label>
                                <div class="bg-light p-3 rounded">{{ $order->admin_notes }}</div>
                </div>
                            @endif
                        </div>
                        </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="card wine-card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-user text-gold me-2"></i> Customer Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Customer Name</label>
                                <div class="fw-bold">{{ $order->customer_name }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Email</label>
                                <div>{{ $order->customer_email }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Phone</label>
                                <div>{{ $order->customer_phone ?: 'Not provided' }}</div>
                </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Shipping Address</label>
                                <div>{{ $order->shipping_address }}</div>
                </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card wine-card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-wine-bottle text-gold me-2"></i> Order Items
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Item</th>
                                    <th>Category</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $items = $order->items;
                                @endphp
                                @if(is_array($items) && count($items) > 0)
                                    @foreach($items as $item)
                                <tr>
                                        <td>
                                            <div class="fw-bold">{{ $item['wine_name'] ?? $item['item_name'] ?? 'Unknown Item' }}</div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $item['wine_category'] ?? $item['category'] ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ $item['quantity'] }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted">${{ number_format($item['unit_price'], 2) }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-success">${{ number_format($item['unit_price'] * $item['quantity'], 2) }}</span>
                                        </td>
                                </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-2x mb-2"></i>
                                            <p>No items found for this order.</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card wine-card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-bolt text-gold me-2"></i> Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($order->status === 'pending')
                            <button type="button" class="btn btn-info" onclick="updateStatus('processing')">
                                <i class="fas fa-cog me-1"></i> Mark as Processing
                            </button>
                        @endif
                        @if($order->status === 'processing')
                            <button type="button" class="btn btn-primary" onclick="updateStatus('shipped')">
                                <i class="fas fa-shipping-fast me-1"></i> Mark as Shipped
                            </button>
                        @endif
                        @if($order->status === 'shipped')
                            <button type="button" class="btn btn-success" onclick="updateStatus('delivered')">
                                <i class="fas fa-check-circle me-1"></i> Mark as Delivered
                            </button>
                        @endif
                        @if(!in_array($order->status, ['delivered', 'cancelled']))
                            <button type="button" class="btn btn-danger" onclick="updateStatus('cancelled')">
                                <i class="fas fa-times-circle me-1"></i> Cancel Order
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Timeline -->
            <div class="card wine-card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-history text-gold me-2"></i> Order Timeline
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <div class="fw-bold">Order Created</div>
                                <small class="text-muted">{{ $order->created_at->format('M d, Y') }}</small>
                            </div>
                        </div>
                        @if($order->status !== 'pending')
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <div class="fw-bold">Order Processing</div>
                                <small class="text-muted">Status updated to processing</small>
                            </div>
                        </div>
                        @endif
                        @if(in_array($order->status, ['shipped', 'delivered']))
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <div class="fw-bold">Order Shipped</div>
                                <small class="text-muted">Status updated to shipped</small>
                            </div>
                        </div>
                        @endif
                        @if($order->status === 'delivered')
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <div class="fw-bold">Order Delivered</div>
                                <small class="text-muted">Status updated to delivered</small>
                            </div>
                        </div>
                        @endif
                        @if($order->status === 'cancelled')
                        <div class="timeline-item">
                            <div class="timeline-marker bg-danger"></div>
                            <div class="timeline-content">
                                <div class="fw-bold">Order Cancelled</div>
                                <small class="text-muted">Status updated to cancelled</small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="statusForm" method="POST" action="{{ route('admin.orders.update', $order) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" id="newStatus">
                <div class="modal-body">
                    <p>Are you sure you want to update the order status to <strong id="statusText"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-burgundy">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function updateStatus(status) {
    const statusText = {
        'pending': 'Pending',
        'processing': 'Processing',
        'shipped': 'Shipped',
        'delivered': 'Delivered',
        'cancelled': 'Cancelled'
    };
    
    document.getElementById('newStatus').value = status;
    document.getElementById('statusText').textContent = statusText[status];
    
    const modal = new bootstrap.Modal(document.getElementById('statusModal'));
    modal.show();
}
</script>
@endpush

@push('styles')
<style>
:root {
    --burgundy: #6a0f1a;
    --light-burgundy: #8b1a1a;
    --dark-burgundy: #4a0a12;
    --gold: #c8a97e;
    --light-gold: #e5d7bf;
    --cream: #f9f5f0;
    --dark-gold: #b8945f;
}

.wine-card {
    border-radius: 12px;
    transition: all 0.3s ease;
}

.wine-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(106, 15, 26, 0.15) !important;
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
    background-color: var(--light-gold);
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 0 0 2px var(--light-gold);
}

.timeline-content {
    padding-left: 10px;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: var(--burgundy);
}

.table td {
    vertical-align: middle;
}
</style>
@endpush 