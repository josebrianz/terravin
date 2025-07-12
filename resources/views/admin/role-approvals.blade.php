@extends('layouts.admin')

@section('title', 'Role Approval Requests')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-check text-primary"></i> Role Approval Requests
        </h1>
        <div class="d-flex">
            <span class="badge bg-warning text-dark me-2">
                <i class="fas fa-clock"></i> {{ $stats['pending'] }} Pending
            </span>
            <span class="badge bg-success me-2">
                <i class="fas fa-check"></i> {{ $stats['approved'] }} Approved
            </span>
            <span class="badge bg-danger">
                <i class="fas fa-times"></i> {{ $stats['rejected'] }} Rejected
            </span>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pending Requests
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Approved Requests
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['approved'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Rejected Requests
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['rejected'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Requests
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-clock text-warning"></i> Pending Approval Requests
            </h6>
            <span class="badge bg-warning text-dark">{{ $pendingRequests->count() }}</span>
        </div>
        <div class="card-body">
            @if($pendingRequests->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="pendingTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Current Role</th>
                                <th>Requested Role</th>
                                <th>Request Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingRequests as $request)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-3">
                                            @if($request->user->profile_photo)
                                                <img src="{{ asset('storage/' . $request->user->profile_photo) }}" 
                                                     class="rounded-circle" width="40" height="40" alt="Profile">
                                            @else
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <span class="text-white fw-bold">{{ substr($request->user->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $request->user->name }}</div>
                                            <small class="text-muted">ID: {{ $request->user->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $request->user->email }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $request->user->role }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $request->requested_role }}</span>
                                </td>
                                <td>{{ $request->created_at->format('M d, Y H:i') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.role-approval.show', $request) }}" 
                                           class="btn btn-sm btn-outline-primary" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-success approve-btn" 
                                                data-request-id="{{ $request->id }}" 
                                                data-user-name="{{ $request->user->name }}"
                                                data-requested-role="{{ $request->requested_role }}"
                                                title="Approve">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger reject-btn" 
                                                data-request-id="{{ $request->id }}"
                                                data-user-name="{{ $request->user->name }}"
                                                title="Reject">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <h5 class="text-success">No Pending Requests</h5>
                    <p class="text-muted">All role approval requests have been processed.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Approved/Rejected Requests -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-check text-success"></i> Recently Approved
                    </h6>
                </div>
                <div class="card-body">
                    @if($approvedRequests->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($approvedRequests as $request)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold">{{ $request->user->name }}</div>
                                    <small class="text-muted">{{ $request->requested_role }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-success">Approved</span>
                                    <br>
                                    <small class="text-muted">{{ $request->approved_at->format('M d, Y') }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center py-3">No approved requests yet.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">
                        <i class="fas fa-times text-danger"></i> Recently Rejected
                    </h6>
                </div>
                <div class="card-body">
                    @if($rejectedRequests->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($rejectedRequests as $request)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold">{{ $request->user->name }}</div>
                                    <small class="text-muted">{{ $request->requested_role }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-danger">Rejected</span>
                                    <br>
                                    <small class="text-muted">{{ $request->approved_at->format('M d, Y') }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center py-3">No rejected requests yet.</p>
                    @endif
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
    // Initialize DataTable
    $('#pendingTable').DataTable({
        order: [[4, 'desc']], // Sort by request date descending
        pageLength: 10,
        language: {
            search: "Search requests:",
            lengthMenu: "Show _MENU_ requests per page",
            info: "Showing _START_ to _END_ of _TOTAL_ requests",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        }
    });

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