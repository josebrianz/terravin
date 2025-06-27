@extends('layouts.app')

@section('title', 'Wine Supply Logistics Dashboard')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-1">Terravin Wine Company</h1>
            <h4 class="text-muted">Logistics Dashboard</h4>
        </div>
        <button class="btn btn-primary" onclick="refreshDashboard()">
            <i class="fas fa-sync-alt"></i> Refresh
        </button>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Shipments</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalShipments) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wine-bottle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($pendingShipments) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">In Transit</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($inTransitShipments) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-truck fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Delivered</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($deliveredShipments) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue and Inventory Row -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Total Revenue</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($totalRevenue, 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Monthly Revenue</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($monthlyRevenue, 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Low Stock Wines</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($lowStockItems->count()) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Overdue</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($overdueShipmentsCount) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Wine Sales Revenue</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Shipment Status</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="shipmentStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- AMap Shipment Routes & Delivery Zones -->
    <!-- (Map section deleted) -->

    <!-- Content Row -->
    <div class="row">
        <!-- Recent Shipments -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Wine Shipments</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tracking #</th>
                                    <th>Status</th>
                                    <th>Customer</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentShipments as $shipment)
                                <tr>
                                    <td>{{ $shipment->tracking_number }}</td>
                                    <td>
                                        <span class="badge {{ $shipment->status_badge }}">
                                            {{ ucfirst(str_replace('_', ' ', $shipment->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $shipment->order->user->name ?? 'N/A' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="viewShipment({{ $shipment->id }})">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="updateStatus({{ $shipment->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Low Stock Alerts -->
        <!-- Removed Low Stock Wine Alerts table as requested -->
    </div>

    <!-- Overdue Shipments -->
    @if($overdueShipments->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4 border-left-danger">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">Overdue Wine Shipments</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tracking #</th>
                                    <th>Customer</th>
                                    <th>Estimated Delivery</th>
                                    <th>Days Overdue</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($overdueShipments as $shipment)
                                <tr class="table-danger">
                                    <td>{{ $shipment->tracking_number }}</td>
                                    <td>{{ $shipment->order->user->name ?? 'N/A' }}</td>
                                    <td>{{ $shipment->estimated_delivery_date->format('M d, Y') }}</td>
                                    <td>{{ $shipment->estimated_delivery_date->diffInDays(now()) }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-success" onclick="markAsDelivered({{ $shipment->id }})">
                                            <i class="fas fa-check"></i> Mark Delivered
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Modals -->
<div class="modal fade" id="statusUpdateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Wine Shipment Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="statusUpdateForm">
                    <input type="hidden" id="shipmentId">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" required>
                            <option value="pending">Pending</option>
                            <option value="in_transit">In Transit</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveStatusUpdate()">Update Status</button>
            </div>
        </div>
    </div>
</div>

<!-- Sidebar -->
<div class="col-lg-4">
    <!-- Upcoming Deliveries -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white border-bottom">
            <h6 class="mb-0 fw-bold text-primary">Upcoming Deliveries</h6>
        </div>
        <div class="card-body">
            @forelse($upcomingDeliveries as $procurement)
            <div class="mb-3 p-2 border-start border-3 border-primary bg-light rounded">
                <h6 class="mb-1 fw-semibold">{{ $procurement->item_name }}</h6>
                <span class="text-muted small">
                    Expected: {{ $procurement->expected_delivery->format('M d, Y') }}<br>
                    Supplier: {{ $procurement->supplier_name }}<br>
                    PO: {{ $procurement->po_number }}
                </span>
            </div>
            @empty
            <p class="text-muted">No upcoming deliveries</p>
            @endforelse
        </div>
    </div>

    <!-- Top Suppliers -->
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom">
            <h6 class="mb-0 fw-bold text-primary">Top Suppliers</h6>
        </div>
        <div class="card-body">
            @forelse($topSuppliers as $supplier)
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="mb-0 fw-semibold">{{ $supplier->supplier_name }}</h6>
                    <span class="text-muted small">{{ $supplier->order_count }} orders</span>
                </div>
                <div class="text-end">
                    <strong>${{ number_format($supplier->total_value, 2) }}</strong>
                </div>
            </div>
            @empty
            <p class="text-muted">No supplier data available</p>
            @endforelse
        </div>
    </div>
</div>
</div>

<hr class="my-4">

<!-- Low Stock Alerts -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h6 class="mb-0 fw-bold text-danger">Low Stock Alerts</h6>
            </div>
            <div class="card-body">
                @if($lowStockItems->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Item Name</th>
                                <th>Current Stock</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lowStockItems as $item)
                            <tr>
                                <td class="fw-semibold">{{ $item->item_name }}</td>
                                <td>
                                    <span class="badge bg-danger">{{ $item->quantity }}</span>
                                </td>
                                <td>{{ $item->description ?? 'No description' }}</td>
                                <td>
                                    <a href="{{ route('inventory.edit', $item) }}" class="btn btn-sm btn-outline-primary" title="Update stock">
                                        <i class="fas fa-edit"></i> Update
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center text-success py-4">
                    <i class="fas fa-check-circle fa-3x mb-3"></i>
                    <h5>All items are well stocked!</h5>
                    <p class="text-muted">No low stock alerts at this time.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="shipmentDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Wine Shipment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="shipmentDetailsContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

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
    font-size: 1.7rem;
    font-weight: 700;
}
.table th, .table td {
    vertical-align: middle;
}
hr {
    border-top: 2px solid #e9ecef;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();
    setupAutoRefresh();
});

function initializeCharts() {
    try {
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart');
        if (!revenueCtx) return;
        const revenueData = {!! json_encode($revenueData) !!};
        const revenueLabels = Object.keys(revenueData);
        const revenueValues = Object.values(revenueData);
        new Chart(revenueCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: revenueLabels,
                datasets: [{
                    label: 'Wine Sales Revenue',
                    data: revenueValues,
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true } }
            }
        });
        // Shipment Status Chart
        const statusCtx = document.getElementById('shipmentStatusChart');
        if (!statusCtx) return;
        const statusData = {!! json_encode($shipmentStatusData) !!};
        const statusLabels = Object.keys(statusData);
        const statusValues = Object.values(statusData);
        new Chart(statusCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusValues,
                    backgroundColor: [
                        '#f6c23e',
                        '#36b9cc',
                        '#1cc88a',
                        '#e74a3b'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    } catch (error) {
        console.error('Error initializing charts:', error);
    }
}

function setupAutoRefresh() {
    setInterval(refreshDashboard, 300000); // 5 minutes
}

function refreshDashboard() {
    location.reload();
}

function updateStatus(shipmentId) {
    document.getElementById('shipmentId').value = shipmentId;
    new bootstrap.Modal(document.getElementById('statusUpdateModal')).show();
}

function saveStatusUpdate() {
    const shipmentId = document.getElementById('shipmentId').value;
    const status = document.getElementById('status').value;
    fetch(`/logistics/shipments/${shipmentId}/status`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('statusUpdateModal')).hide();
            location.reload();
        } else {
            alert('Error updating status');
        }
    })
    .catch(error => {
        alert('Error updating status');
    });
}

function viewShipment(shipmentId) {
    alert('viewShipment called with id: ' + shipmentId);
    fetch(`/logistics/shipments/${shipmentId}`)
    .then(response => response.json())
    .then(data => {
        const content = `
            <div class="row">
                <div class="col-md-6">
                    <h6>Wine Shipment Information</h6>
                    <p><strong>Tracking Number:</strong> ${data.shipment.tracking_number}</p>
                    <p><strong>Status:</strong> <span class="badge bg-${getStatusColor(data.shipment.status)}">${data.shipment.status}</span></p>
                    <p><strong>Carrier:</strong> ${data.shipment.carrier || 'N/A'}</p>
                    <p><strong>Shipping Cost:</strong> $${data.shipment.shipping_cost}</p>
                </div>
                <div class="col-md-6">
                    <h6>Order Information</h6>
                    <p><strong>Order ID:</strong> ${data.shipment.order.id}</p>
                    <p><strong>Customer:</strong> ${data.shipment.order.user.name}</p>
                    <p><strong>Total Amount:</strong> $${data.shipment.order.total_amount}</p>
                    <p><strong>Order Status:</strong> ${data.shipment.order.status}</p>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <h6>Shipping Address</h6>
                    <p>${data.shipment.shipping_address}</p>
                </div>
            </div>
        `;
        document.getElementById('shipmentDetailsContent').innerHTML = content;
        new bootstrap.Modal(document.getElementById('shipmentDetailsModal')).show();
    });
}

function markAsDelivered(shipmentId) {
    if (confirm('Mark this wine shipment as delivered?')) {
        fetch(`/logistics/shipments/${shipmentId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: 'delivered' })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error updating status');
            }
        });
    }
}

function getStatusColor(status) {
    const colors = {
        'pending': 'warning',
        'in_transit': 'info',
        'delivered': 'success',
        'cancelled': 'danger'
    };
    return colors[status] || 'secondary';
}
</script>
@endpush
