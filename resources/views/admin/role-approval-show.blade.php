@extends('layouts.admin')

@section('title', 'Role Approval Request Details')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-check text-primary"></i> Role Approval Request Details
        </h1>
        <a href="{{ route('admin.role-approvals') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Requests
        </a>
    </div>

    <div class="row">
        <!-- Request Details -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle"></i> Request Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Request ID:</td>
                                    <td>#{{ $roleApprovalRequest->id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Status:</td>
                                    <td>
                                        <span class="badge {{ $roleApprovalRequest->status_badge_class }}">
                                            {{ $roleApprovalRequest->status_display_name }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Requested Role:</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $roleApprovalRequest->requested_role }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Request Date:</td>
                                    <td>{{ $roleApprovalRequest->created_at->format('M d, Y H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                @if($roleApprovalRequest->approved_by)
                                <tr>
                                    <td class="fw-bold">Processed By:</td>
                                    <td>{{ $roleApprovalRequest->approver->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Processed Date:</td>
                                    <td>{{ $roleApprovalRequest->approved_at->format('M d, Y H:i:s') }}</td>
                                </tr>
                                @endif
                                @if($roleApprovalRequest->admin_notes)
                                <tr>
                                    <td class="fw-bold">Admin Notes:</td>
                                    <td>{{ $roleApprovalRequest->admin_notes }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user"></i> User Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            @if($roleApprovalRequest->user->profile_photo)
                                <img src="{{ asset('storage/' . $roleApprovalRequest->user->profile_photo) }}" 
                                     class="rounded-circle mb-3" width="100" height="100" alt="Profile">
                            @else
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                                     style="width: 100px; height: 100px;">
                                    <span class="text-white fw-bold" style="font-size: 2rem;">{{ substr($roleApprovalRequest->user->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold" width="150">Name:</td>
                                    <td>{{ $roleApprovalRequest->user->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Email:</td>
                                    <td>{{ $roleApprovalRequest->user->email }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">User ID:</td>
                                    <td>{{ $roleApprovalRequest->user->id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Current Role:</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $roleApprovalRequest->user->role }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Member Since:</td>
                                    <td>{{ $roleApprovalRequest->user->created_at->format('M d, Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Role Comparison -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-exchange-alt"></i> Role Comparison
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Current Role: <span class="badge bg-secondary">{{ $roleApprovalRequest->user->role }}</span></h6>
                            <div class="small text-muted">
                                <p>Basic customer access for order management</p>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-check text-success"></i> View own orders</li>
                                    <li><i class="fas fa-check text-success"></i> Create orders</li>
                                    <li><i class="fas fa-check text-success"></i> View available inventory</li>
                                    <li><i class="fas fa-check text-success"></i> Track own shipments</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Requested Role: <span class="badge bg-primary">{{ $roleApprovalRequest->requested_role }}</span></h6>
                            <div class="small text-muted">
                                @if($roleApprovalRequest->requested_role === 'Wholesaler')
                                    <p>Wholesaler access for order management and inventory viewing</p>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check text-success"></i> View inventory</li>
                                        <li><i class="fas fa-check text-success"></i> View orders</li>
                                        <li><i class="fas fa-check text-success"></i> Update order status</li>
                                        <li><i class="fas fa-check text-success"></i> Create order reports</li>
                                    </ul>
                                @elseif($roleApprovalRequest->requested_role === 'Retailer')
                                    <p>Retailer access for procurement and inventory management</p>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check text-success"></i> View inventory</li>
                                        <li><i class="fas fa-check text-success"></i> Create procurement</li>
                                        <li><i class="fas fa-check text-success"></i> Edit procurement</li>
                                        <li><i class="fas fa-check text-success"></i> Create procurement reports</li>
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Panel -->
        <div class="col-lg-4">
            @if($roleApprovalRequest->isPending())
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-cogs"></i> Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success approve-btn" 
                                data-request-id="{{ $roleApprovalRequest->id }}"
                                data-user-name="{{ $roleApprovalRequest->user->name }}"
                                data-requested-role="{{ $roleApprovalRequest->requested_role }}">
                            <i class="fas fa-check"></i> Approve Request
                        </button>
                        <button type="button" class="btn btn-danger reject-btn"
                                data-request-id="{{ $roleApprovalRequest->id }}"
                                data-user-name="{{ $roleApprovalRequest->user->name }}">
                            <i class="fas fa-times"></i> Reject Request
                        </button>
                    </div>
                </div>
            </div>
            @else
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle"></i> Request Status
                    </h6>
                </div>
                <div class="card-body text-center">
                    @if($roleApprovalRequest->isApproved())
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <h5 class="text-success">Request Approved</h5>
                        <p class="text-muted">This request has been approved and the user's role has been updated.</p>
                    @elseif($roleApprovalRequest->isRejected())
                        <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                        <h5 class="text-danger">Request Rejected</h5>
                        <p class="text-muted">This request has been rejected.</p>
                    @endif
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt"></i> Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.edit-user', $roleApprovalRequest->user->id) }}" 
                           class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit User Profile
                        </a>
                        <a href="{{ route('admin.manage-roles') }}" 
                           class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-users"></i> Manage All Users
                        </a>
                        <a href="{{ route('admin.role-approvals') }}" 
                           class="btn btn-outline-info btn-sm">
                            <i class="fas fa-list"></i> View All Requests
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveModalLabel">Approve Role Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="approveForm">
                <div class="modal-body">
                    <p>Are you sure you want to approve <strong id="approveUserName"></strong>'s request for <strong id="approveRoleName"></strong> role?</p>
                    <div class="mb-3">
                        <label for="approveNotes" class="form-label">Admin Notes (Optional)</label>
                        <textarea class="form-control" id="approveNotes" name="admin_notes" rows="3" placeholder="Add any notes about this approval..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i> Approve Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Reject Role Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectForm">
                <div class="modal-body">
                    <p>Are you sure you want to reject <strong id="rejectUserName"></strong>'s role request?</p>
                    <div class="mb-3">
                        <label for="rejectNotes" class="form-label">Rejection Reason <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="rejectNotes" name="admin_notes" rows="3" placeholder="Please provide a reason for rejection..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times"></i> Reject Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 mb-0">Processing request...</p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Approve button click
    $('.approve-btn').on('click', function() {
        const requestId = $(this).data('request-id');
        const userName = $(this).data('user-name');
        const requestedRole = $(this).data('requested-role');
        
        $('#approveUserName').text(userName);
        $('#approveRoleName').text(requestedRole);
        $('#approveForm').data('request-id', requestId);
        
        const approveModal = new bootstrap.Modal(document.getElementById('approveModal'));
        approveModal.show();
    });

    // Reject button click
    $('.reject-btn').on('click', function() {
        const requestId = $(this).data('request-id');
        const userName = $(this).data('user-name');
        
        $('#rejectUserName').text(userName);
        $('#rejectForm').data('request-id', requestId);
        
        const rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
        rejectModal.show();
    });

    // Approve form submission
    $('#approveForm').on('submit', function(e) {
        e.preventDefault();
        
        const requestId = $(this).data('request-id');
        const formData = new FormData(this);
        
        // Show loading modal
        const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
        loadingModal.show();
        
        // Hide approve modal
        const approveModal = bootstrap.Modal.getInstance(document.getElementById('approveModal'));
        approveModal.hide();
        
        $.ajax({
            url: `/admin/role-approvals/${requestId}/approve`,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                loadingModal.hide();
                showAlert('success', response.message);
                setTimeout(() => {
                    location.reload();
                }, 1500);
            },
            error: function(xhr) {
                loadingModal.hide();
                const response = xhr.responseJSON;
                showAlert('error', response.message || 'An error occurred while approving the request.');
            }
        });
    });

    // Reject form submission
    $('#rejectForm').on('submit', function(e) {
        e.preventDefault();
        
        const requestId = $(this).data('request-id');
        const formData = new FormData(this);
        
        // Show loading modal
        const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
        loadingModal.show();
        
        // Hide reject modal
        const rejectModal = bootstrap.Modal.getInstance(document.getElementById('rejectModal'));
        rejectModal.hide();
        
        $.ajax({
            url: `/admin/role-approvals/${requestId}/reject`,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                loadingModal.hide();
                showAlert('success', response.message);
                setTimeout(() => {
                    location.reload();
                }, 1500);
            },
            error: function(xhr) {
                loadingModal.hide();
                const response = xhr.responseJSON;
                showAlert('error', response.message || 'An error occurred while rejecting the request.');
            }
        });
    });

    // Alert function
    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        // Remove existing alerts
        $('.alert').remove();
        
        // Add new alert at the top
        $('.container-fluid').prepend(alertHtml);
        
        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            $('.alert').fadeOut();
        }, 5000);
    }
});
</script>
@endpush 