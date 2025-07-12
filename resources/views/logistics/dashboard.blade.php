@extends('layouts.app')

@section('title', 'Logistics Dashboard')

@section('navigation')
<!-- Hide the default navigation bar for this page -->
<style>
    nav.wine-navbar.border-b, nav.border-b {
        display: none !important;
    }
</style>
@endsection

@section('content')
<!-- Custom Top Nav for Logistics Dashboard -->
<nav class="navbar navbar-expand-lg navbar-dark bg-burgundy fixed-top shadow wine-navbar" style="background: linear-gradient(90deg, #5e0f0f 0%, #7b2230 100%); z-index: 1050;">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('logistics.dashboard') }}">
            <span class="me-2" style="font-size: 2rem;"><i class="fas fa-wine-bottle"></i></span>
            <span class="fw-bold" style="color: #c8a97e;">Terravin Logistics</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#logisticsNavbar" aria-controls="logisticsNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="logisticsNavbar">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="{{ route('logistics.dashboard') }}"><i class="fas fa-tachometer-alt me-1"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="#shipments"><i class="fas fa-truck me-1"></i> Shipments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="{{ route('inventory.index') }}"><i class="fas fa-boxes me-1"></i> Inventory</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="{{ route('orders.index') }}"><i class="fas fa-clipboard-list me-1"></i> Orders</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-bold" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i> Profile
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Edit Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger" type="submit"><i class="fas fa-sign-out-alt me-1"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div style="height: 70px;"></div> <!-- Spacer for fixed nav -->
<style>
:root {
    --burgundy: #5e0f0f;
    --gold: #c8a97e;
    --cream: #f5f0e6;
    --light-burgundy: #8b1a1a;
    --dark-gold: #b8945f;
}
.wine-theme-bg {
    background: linear-gradient(135deg, var(--cream) 0%, #fff 100%), url('/public/images/chateu-rouge.jpg') center/cover no-repeat;
    min-height: 100vh;
}
.card, .stat-card {
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(94, 15, 15, 0.08);
    border: none;
    background: #fff7f3;
}
.page-header {
    background: linear-gradient(135deg, var(--cream) 0%, #fff 100%);
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(94, 15, 15, 0.1);
}
.text-burgundy {
    color: var(--burgundy) !important;
}
.text-gold {
    color: var(--gold) !important;
}
.bg-burgundy {
    background-color: var(--burgundy) !important;
}
.bg-gold {
    background-color: var(--gold) !important;
}
/* BUTTON VISIBILITY ENHANCEMENTS */
.btn, .btn-burgundy, .btn-gold, .btn-outline-burgundy, .btn-outline-gold {
    font-size: 1.1rem !important;
    font-weight: 700 !important;
    border-width: 2px !important;
    border-radius: 8px !important;
    box-shadow: 0 2px 8px rgba(94, 15, 15, 0.10) !important;
    transition: all 0.2s !important;
    outline: none !important;
}
.btn-burgundy {
    background-color: var(--burgundy) !important;
    border-color: var(--burgundy) !important;
    color: #fff !important;
}
.btn-burgundy:hover, .btn-burgundy:focus {
    background-color: var(--light-burgundy) !important;
    border-color: var(--light-burgundy) !important;
    color: #fff !important;
    box-shadow: 0 4px 16px rgba(94, 15, 15, 0.18) !important;
}
.btn-gold {
    background-color: var(--gold) !important;
    border-color: var(--gold) !important;
    color: var(--burgundy) !important;
}
.btn-gold:hover, .btn-gold:focus {
    background-color: var(--dark-gold) !important;
    border-color: var(--dark-gold) !important;
    color: var(--burgundy) !important;
    box-shadow: 0 4px 16px rgba(200, 169, 126, 0.18) !important;
}
.btn-outline-burgundy {
    border-color: var(--burgundy) !important;
    color: var(--burgundy) !important;
    background: #fff !important;
}
.btn-outline-burgundy:hover, .btn-outline-burgundy:focus {
    background-color: var(--burgundy) !important;
    color: #fff !important;
    box-shadow: 0 4px 16px rgba(94, 15, 15, 0.18) !important;
}
.btn-outline-gold {
    border-color: var(--gold) !important;
    color: var(--gold) !important;
    background: #fff !important;
}
.btn-outline-gold:hover, .btn-outline-gold:focus {
    background-color: var(--gold) !important;
    color: var(--burgundy) !important;
    box-shadow: 0 4px 16px rgba(200, 169, 126, 0.18) !important;
}
.wine-list-item {
    background: #f5f0e6;
    border-left: 4px solid var(--burgundy);
    margin-bottom: 0.5rem;
    padding: 0.75rem 1rem;
    border-radius: 8px;
}
.wine-action-btn {
    min-width: 200px;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.2s;
}
.wine-action-btn:active {
    transform: scale(0.98);
}
.wine-navbar {
    background: linear-gradient(90deg, #5e0f0f 0%, #7b2230 100%) !important;
    color: #fff !important;
}
.wine-navbar a, .wine-navbar .dropdown-link, .wine-navbar .nav-link, .wine-navbar .font-medium {
    color: #fff !important;
}
.wine-navbar a:hover, .wine-navbar .dropdown-link:hover, .wine-navbar .nav-link:hover {
    color: #c8a97e !important;
}
.wine-navbar .wine-logo {
    font-size: 2rem;
    color: #c8a97e;
    margin-right: 0.5rem;
}
.wine-navbar .wine-btn {
    background: #b85c38;
    color: #fff;
    border-radius: 2rem;
    padding: 0.3rem 1.2rem;
    font-weight: bold;
    transition: background 0.2s;
}
.wine-navbar .wine-btn:hover {
    background: #7b2230;
    color: #fff;
}
.wine-navbar .dropdown-menu {
    background: #fff7f3;
}
</style>
<div class="wine-theme-bg min-vh-100">
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-header border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h1 class="page-title mb-0 fw-bold text-burgundy">
                            <i class="fas fa-truck me-2 text-gold"></i>
                            Logistics Dashboard
                        </h1>
                        <span class="text-muted small">Monitor and manage all logistics operations in real time</span>
                    </div>
                    <div class="header-actions d-flex align-items-center gap-2">
                        <button class="btn btn-gold shadow-sm" data-bs-toggle="modal" data-bs-target="#createShipmentModal">
                            <i class="fas fa-plus me-1"></i> New Shipment
                        </button>
                        <a href="{{ route('logistics.dashboard') }}" class="btn btn-outline-burgundy shadow-sm">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </a>
                        <span class="badge bg-gold text-burgundy px-3 py-2">
                            <i class="fas fa-clock me-1"></i>
                            {{ now()->format('M d, Y H:i') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Overview Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-2 col-6">
                <div class="card shadow-sm text-center stat-card h-100">
                    <div class="card-body">
                        <i class="fas fa-shipping-fast fa-2x text-gold mb-2"></i>
                        <h6 class="fw-bold">Total Shipments</h6>
                        <div class="display-6 fw-bold">{{ $totalShipments ?? 0 }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="card shadow-sm text-center stat-card h-100">
                    <div class="card-body">
                        <i class="fas fa-clock fa-2x text-burgundy mb-2"></i>
                        <h6 class="fw-bold">Pending</h6>
                        <div class="display-6 fw-bold">{{ $pendingShipments ?? 0 }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="card shadow-sm text-center stat-card h-100">
                    <div class="card-body">
                        <i class="fas fa-truck-loading fa-2x text-gold mb-2"></i>
                        <h6 class="fw-bold">In Transit</h6>
                        <div class="display-6 fw-bold">{{ $inTransitShipments ?? 0 }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="card shadow-sm text-center stat-card h-100">
                    <div class="card-body">
                        <i class="fas fa-box-open fa-2x text-burgundy mb-2"></i>
                        <h6 class="fw-bold">Delivered</h6>
                        <div class="display-6 fw-bold">{{ $deliveredShipments ?? 0 }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="card shadow-sm text-center stat-card h-100">
                    <div class="card-body">
                        <i class="fas fa-exclamation-triangle fa-2x text-gold mb-2"></i>
                        <h6 class="fw-bold">Overdue</h6>
                        <div class="display-6 fw-bold">{{ $overdueShipmentsCount ?? 0 }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <div class="card shadow-sm text-center stat-card h-100">
                    <div class="card-body">
                        <i class="fas fa-boxes fa-2x text-gold mb-2"></i>
                        <h6 class="fw-bold">Low Stock</h6>
                        <div class="display-6 fw-bold">{{ $lowStockItems->count() ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Shipment Status Chart & Quick Actions -->
        <div class="row mb-4 g-3">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom-0 d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0 fw-bold text-burgundy">
                            <i class="fas fa-chart-pie text-gold me-2"></i> Shipment Status Overview
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="shipmentStatusChart" height="120"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom-0">
                        <h5 class="card-title mb-0 fw-bold text-burgundy">
                            <i class="fas fa-bolt text-gold me-2"></i> Quick Actions
                        </h5>
                    </div>
                    <div class="card-body d-grid gap-2">
                        <a href="#" class="btn btn-burgundy shadow-sm" data-bs-toggle="modal" data-bs-target="#createShipmentModal"><i class="fas fa-plus"></i> Create Shipment</a>
                        <a href="{{ route('orders.index') }}" class="btn btn-gold shadow-sm"><i class="fas fa-clipboard-list"></i> View Orders</a>
                        <a href="{{ route('inventory.index') }}" class="btn btn-outline-burgundy shadow-sm"><i class="fas fa-boxes"></i> Inventory</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Recent Shipments Table -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom-0 d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0 fw-bold text-burgundy">
                            <i class="fas fa-truck text-gold me-2"></i> Recent Shipments
                        </h5>
                        <a href="#" class="btn btn-outline-secondary btn-sm">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Status</th>
                                        <th>Cost</th>
                                        <th>Destination</th>
                                        <th>Order</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentShipments ?? [] as $shipment)
                                    <tr>
                                        <td>#{{ $shipment->id }}</td>
                                        <td><span class="badge bg-{{ $shipment->status == 'delivered' ? 'success' : ($shipment->status == 'in_transit' ? 'warning' : ($shipment->status == 'pending' ? 'secondary' : 'danger')) }}">{{ ucfirst($shipment->status) }}</span></td>
                                        <td>UGX {{ number_format($shipment->shipping_cost, 0) }}</td>
                                        <td>{{ $shipment->order->delivery_address ?? 'N/A' }}</td>
                                        <td>#{{ $shipment->order->id ?? 'N/A' }}</td>
                                        <td>{{ $shipment->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-gold" data-bs-toggle="modal" data-bs-target="#shipmentDetailsModal" data-shipment-id="{{ $shipment->id }}"><i class="fas fa-eye"></i></button>
                                            <button class="btn btn-sm btn-outline-burgundy" data-bs-toggle="modal" data-bs-target="#updateStatusModal" data-shipment-id="{{ $shipment->id }}"><i class="fas fa-edit"></i></button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">No recent shipments</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Upcoming Deliveries Table -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom-0">
                        <h5 class="card-title mb-0 fw-bold text-burgundy">
                            <i class="fas fa-calendar-alt text-gold me-2"></i> Upcoming Deliveries
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Expected Date</th>
                                        <th>Supplier</th>
                                        <th>Order</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($upcomingDeliveries ?? [] as $delivery)
                                    <tr>
                                        <td>#{{ $delivery->id }}</td>
                                        <td>{{ $delivery->expected_delivery }}</td>
                                        <td>{{ $delivery->supplier_name ?? 'N/A' }}</td>
                                        <td>#{{ $delivery->order_id ?? 'N/A' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">No upcoming deliveries</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Low Stock Items Table -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom-0">
                        <h5 class="card-title mb-0 fw-bold text-burgundy">
                            <i class="fas fa-boxes text-gold me-2"></i> Low Stock Items
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                        <th>Reorder</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($lowStockItems ?? [] as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td><a href="#" class="btn btn-sm btn-outline-gold"><i class="fas fa-cart-plus"></i> Reorder</a></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">No low stock items</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals (now functional) -->
<div class="modal fade" id="createShipmentModal" tabindex="-1" aria-labelledby="createShipmentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="createShipmentForm">
        <div class="modal-header">
          <h5 class="modal-title" id="createShipmentModalLabel">Create New Shipment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="order_id" class="form-label">Order</label>
            <select class="form-select" id="order_id" name="order_id" required>
              <option value="">Select Order</option>
              @foreach($orders as $order)
                <option value="{{ $order->id }}">#{{ $order->id }} - {{ $order->customer_name ?? $order->user->name ?? 'N/A' }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
              <option value="pending">Pending</option>
              <option value="in_transit">In Transit</option>
              <option value="delivered">Delivered</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="shipping_cost" class="form-label">Shipping Cost (UGX)</label>
            <input type="number" class="form-control" id="shipping_cost" name="shipping_cost" min="0" required>
          </div>
          <div class="mb-3">
            <label for="estimated_delivery_date" class="form-label">Estimated Delivery Date</label>
            <input type="date" class="form-control" id="estimated_delivery_date" name="estimated_delivery_date">
          </div>
          <div id="createShipmentError" class="alert alert-danger d-none"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-burgundy">Create Shipment</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="shipmentDetailsModal" tabindex="-1" aria-labelledby="shipmentDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="shipmentDetailsModalLabel">Shipment Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="shipmentDetailsBody">
        <p>Loading...</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="updateStatusForm">
        <div class="modal-header">
          <h5 class="modal-title" id="updateStatusModalLabel">Update Shipment Status</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="update_shipment_id" name="shipment_id">
          <div class="mb-3">
            <label for="update_status" class="form-label">Status</label>
            <select class="form-select" id="update_status" name="status" required>
              <option value="pending">Pending</option>
              <option value="in_transit">In Transit</option>
              <option value="delivered">Delivered</option>
              <option value="cancelled">Cancelled</option>
            </select>
          </div>
          <div id="updateStatusError" class="alert alert-danger d-none"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-gold">Update Status</button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// CSRF token for AJAX
const csrfToken = '{{ csrf_token() }}';

// Create Shipment AJAX
$('#createShipmentForm').on('submit', function(e) {
    e.preventDefault();
    const form = $(this);
    const data = form.serialize();
    $.ajax({
        url: '{{ route('logistics.shipments.store') }}',
        method: 'POST',
        data: data,
        headers: { 'X-CSRF-TOKEN': csrfToken },
        success: function(response) {
            $('#createShipmentModal').modal('hide');
            location.reload();
        },
        error: function(xhr) {
            $('#createShipmentError').removeClass('d-none').text(xhr.responseJSON?.message || 'Error creating shipment.');
        }
    });
});

// Load Shipment Details AJAX
$('#shipmentDetailsModal').on('show.bs.modal', function(event) {
    const button = $(event.relatedTarget);
    const shipmentId = button.data('shipment-id');
    const modalBody = $('#shipmentDetailsBody');
    modalBody.html('<p>Loading...</p>');
    $.get('/logistics/shipments/' + shipmentId, function(data) {
        if (data.shipment) {
            const s = data.shipment;
            modalBody.html(`
                <ul class="list-group">
                    <li class="list-group-item"><strong>ID:</strong> #${s.id}</li>
                    <li class="list-group-item"><strong>Status:</strong> ${s.status}</li>
                    <li class="list-group-item"><strong>Shipping Cost:</strong> UGX ${s.shipping_cost}</li>
                    <li class="list-group-item"><strong>Order ID:</strong> #${s.order_id}</li>
                    <li class="list-group-item"><strong>Estimated Delivery:</strong> ${s.estimated_delivery_date ?? 'N/A'}</li>
                    <li class="list-group-item"><strong>Created:</strong> ${s.created_at}</li>
                </ul>
            `);
        } else {
            modalBody.html('<p>Shipment not found.</p>');
        }
    }).fail(function() {
        modalBody.html('<p>Error loading shipment details.</p>');
    });
});

// Update Status Modal: set shipment id
$('#updateStatusModal').on('show.bs.modal', function(event) {
    const button = $(event.relatedTarget);
    const shipmentId = button.data('shipment-id');
    $('#update_shipment_id').val(shipmentId);
});

// Update Status AJAX
$('#updateStatusForm').on('submit', function(e) {
    e.preventDefault();
    const shipmentId = $('#update_shipment_id').val();
    const status = $('#update_status').val();
    $.ajax({
        url: '/logistics/shipments/' + shipmentId + '/status',
        method: 'PUT',
        data: { status: status, _token: csrfToken },
        success: function(response) {
            $('#updateStatusModal').modal('hide');
            location.reload();
        },
        error: function(xhr) {
            $('#updateStatusError').removeClass('d-none').text(xhr.responseJSON?.message || 'Error updating status.');
        }
    });
});
</script>
@endpush
