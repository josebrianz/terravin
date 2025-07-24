@extends('layouts.admin')

@section('title', 'Admin Orders Management - TERRAVIN')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-truck-loading me-2 text-gold"></i>
                        Vendor Orders Management
                    </h1>
                    <span class="text-muted small">Manage and track all orders placed by vendors.</span>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.orders.export') }}" class="btn btn-outline-burgundy me-2">
                        <i class="fas fa-download me-1"></i> Export Orders
                    </a>
                    <span class="badge bg-burgundy text-gold px-4 py-3 fs-6 fw-bold shadow-sm">
                        <i class="fas fa-clock me-2"></i>
                        {{ now()->format('M d, Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="icon-circle bg-burgundy">
                            <i class="fas fa-truck-loading fa-2x text-gold"></i>
                        </div>
                    </div>
                    <h3 class="text-burgundy fw-bold mb-1">{{ number_format($orders->total()) }}</h3>
                    <p class="text-muted small mb-0">Total Vendor Orders</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="icon-circle bg-warning">
                            <i class="fas fa-clock fa-2x text-white"></i>
                        </div>
                    </div>
                    <h3 class="text-burgundy fw-bold mb-1">{{ number_format($orders->where('status', 'pending')->count()) }}</h3>
                    <p class="text-muted small mb-0">Pending Vendor Orders</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="icon-circle bg-success">
                            <i class="fas fa-check-circle fa-2x text-white"></i>
                        </div>
                    </div>
                    <h3 class="text-burgundy fw-bold mb-1">{{ number_format($orders->where('status', 'delivered')->count()) }}</h3>
                    <p class="text-muted small mb-0">Delivered Vendor Orders</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="icon-circle bg-gold">
                            <i class="fas fa-dollar-sign fa-2x text-burgundy"></i>
                        </div>
                    </div>
                    <h3 class="text-burgundy fw-bold mb-1">${{ number_format($orders->sum('total_amount'), 2) }}</h3>
                    <p class="text-muted small mb-0">Total Vendor Revenue</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-filter text-gold me-2"></i> Filters & Search
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Statuses</option>
                                <option value="pending" @if(request('status')=='pending') selected @endif>Pending</option>
                                <option value="processing" @if(request('status')=='processing') selected @endif>Processing</option>
                                <option value="shipped" @if(request('status')=='shipped') selected @endif>Shipped</option>
                                <option value="delivered" @if(request('status')=='delivered') selected @endif>Delivered</option>
                                <option value="cancelled" @if(request('status')=='cancelled') selected @endif>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Vendor Name</label>
                            <input type="text" name="customer_name" class="form-control" value="{{ request('customer_name') }}" placeholder="Search by vendor name">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Vendor Email</label>
                            <input type="email" name="customer_email" class="form-control" value="{{ request('customer_email') }}" placeholder="Search by vendor email">
                        </div>
                        <div class="col-12">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-burgundy">
                                    <i class="fas fa-search me-1"></i> Apply Filters
                                </button>
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-burgundy">
                                    <i class="fas fa-times me-1"></i> Clear Filters
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-12">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-list text-gold me-2"></i> Vendor Orders ({{ $orders->total() }})
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Vendor</th>
                                    <th>Email</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td><span class="fw-bold text-burgundy">#{{ $order->id }}</span></td>
                                    <td>{{ $order->customer_name }}</td>
                                    <td><small class="text-muted">{{ $order->customer_email }}</small></td>
                                    <td>
                                        @php
                                            $items = is_array($order->items) ? $order->items : json_decode($order->items, true);
                                            $itemCount = is_array($items) ? count($items) : 0;
                                        @endphp
                                        <span class="badge bg-light text-dark">{{ $itemCount }} items</span>
                                    </td>
                                    <td><span class="fw-bold text-success">${{ number_format($order->total_amount, 2) }}</span></td>
                                    <td>
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
                                    </td>
                                    <td><small class="text-muted">{{ $order->created_at->format('M d, Y') }}</small></td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-burgundy" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-outline-gold" title="Edit Order">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.orders.invoice', $order) }}" class="btn btn-outline-info" title="Generate Invoice">
                                                <i class="fas fa-file-invoice"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p>No vendor orders found matching your criteria.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-top-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} vendor orders</small>
                        </div>
                        <div>
                            {{ $orders->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Actions Modal -->
<div class="modal fade" id="bulkActionsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bulk Actions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.orders.bulk-update') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Selected Orders: <span id="selected-count">0</span></label>
                        <div id="selected-orders-list" class="mt-2"></div>
                    </div>
                    <div class="mb-3">
                        <label for="bulk-status" class="form-label">Update Status To:</label>
                        <select name="status" id="bulk-status" class="form-select" required>
                            <option value="">Select Status</option>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-burgundy">Update Orders</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all functionality
    const selectAllCheckbox = document.getElementById('select-all');
    const orderCheckboxes = document.querySelectorAll('.order-checkbox');
    
    selectAllCheckbox.addEventListener('change', function() {
        orderCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateSelectedCount();
    });
    
    orderCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectedCount();
            updateSelectAllState();
        });
    });
    
    function updateSelectedCount() {
        const selected = document.querySelectorAll('.order-checkbox:checked');
        const count = selected.length;
        document.getElementById('selected-count').textContent = count;
        
        if (count > 0) {
            showBulkActionsButton();
        } else {
            hideBulkActionsButton();
        }
    }
    
    function updateSelectAllState() {
        const checked = document.querySelectorAll('.order-checkbox:checked').length;
        const total = orderCheckboxes.length;
        selectAllCheckbox.checked = checked === total;
        selectAllCheckbox.indeterminate = checked > 0 && checked < total;
    }
    
    function showBulkActionsButton() {
        // Add bulk actions button if not exists
        if (!document.getElementById('bulk-actions-btn')) {
            const headerActions = document.querySelector('.header-actions');
            const bulkBtn = document.createElement('button');
            bulkBtn.id = 'bulk-actions-btn';
            bulkBtn.className = 'btn btn-burgundy ms-2';
            bulkBtn.innerHTML = '<i class="fas fa-tasks me-1"></i> Bulk Actions';
            bulkBtn.onclick = showBulkActionsModal;
            headerActions.appendChild(bulkBtn);
        }
    }
    
    function hideBulkActionsButton() {
        const bulkBtn = document.getElementById('bulk-actions-btn');
        if (bulkBtn) {
            bulkBtn.remove();
        }
    }
    
    function showBulkActionsModal() {
        const selected = document.querySelectorAll('.order-checkbox:checked');
        const modal = new bootstrap.Modal(document.getElementById('bulkActionsModal'));
        
        // Update selected orders list
        const list = document.getElementById('selected-orders-list');
        list.innerHTML = '';
        selected.forEach(checkbox => {
            const row = checkbox.closest('tr');
            const orderId = row.querySelector('td:nth-child(2)').textContent;
            const customerName = row.querySelector('td:nth-child(3) .fw-bold').textContent;
            list.innerHTML += `<div class="badge bg-light text-dark me-1 mb-1">${orderId} - ${customerName}</div>`;
        });
        
        modal.show();
    }
});

function selectAll() {
    const selectAllCheckbox = document.getElementById('select-all');
    selectAllCheckbox.checked = !selectAllCheckbox.checked;
    selectAllCheckbox.dispatchEvent(new Event('change'));
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

.icon-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.avatar-sm {
    width: 40px;
    height: 40px;
}

.badge-sm {
    font-size: 0.75em;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: var(--burgundy);
}

.table td {
    vertical-align: middle;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.pagination .page-link {
    color: var(--burgundy);
    border-color: var(--light-gold);
}

.pagination .page-item.active .page-link {
    background-color: var(--burgundy);
    border-color: var(--burgundy);
}

.pagination .page-link:hover {
    color: var(--burgundy);
    background-color: var(--light-gold);
}

/* Enhanced date badge styling */
.badge.bg-burgundy {
    background: linear-gradient(135deg, var(--burgundy) 0%, var(--light-burgundy) 100%) !important;
    border: 2px solid var(--gold);
    box-shadow: 0 4px 15px rgba(106, 15, 26, 0.3);
    transition: all 0.3s ease;
}

.badge.bg-burgundy:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(106, 15, 26, 0.4);
}

.badge.bg-burgundy i {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.7; }
    100% { opacity: 1; }
}
</style>
@endpush