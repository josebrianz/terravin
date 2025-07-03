@extends('layouts.admin')

@section('title', 'Role Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Role Management</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Role Statistics -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5>Role Statistics</h5>
                            <div class="row">
                                @foreach($availableRoles as $roleName => $roleData)
                                    <div class="col-md-2 col-sm-4 col-6 mb-3">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-{{
                                                $roleName === 'Admin' ? 'danger' :
                                                ($roleName === 'Vendor' ? 'info' :
                                                ($roleName === 'Retailer' ? 'success' :
                                                ($roleName === 'Supplier' ? 'warning' : 'secondary')))
                                            }}">
                                                <i class="fas fa-users"></i>
                                            </span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">{{ $roleName }}</span>
                                                <span class="info-box-number">{{ $users->where('role', $roleName)->count() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Add New User -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Add New User</h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.add-user') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input type="text" class="form-control" id="name" name="name" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input type="password" class="form-control" id="password" name="password" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="password_confirmation">Confirm Password</label>
                                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="role">Role</label>
                                                    <select class="form-control" id="role" name="role" required>
                                                        <option value="">Select Role</option>
                                                        @foreach($availableRoles as $roleName => $roleData)
                                                            <option value="{{ $roleName }}">{{ $roleName }} - {{ $roleData['description'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <button type="submit" class="btn btn-primary btn-block">Add User</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Users List -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Manage Users</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Role</th>
                                                    <th>Created</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($users as $user)
                                                    <tr class="{{ $user->id === auth()->id() ? 'table-warning' : '' }}">
                                                        <td>{{ $user->id }}</td>
                                                        <td>
                                                            {{ $user->name }}
                                                            @if($user->id === auth()->id())
                                                                <span class="badge badge-info ml-2">You</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span class="badge bg-{{ $user->getRoleColor() }} me-2">
                                                                    {{ $user->getRoleDisplayName() }}
                                                                </span>
                                                                @if($user->id !== auth()->id())
                                                                    <select class="form-control form-control-sm role-select" 
                                                                            data-user-id="{{ $user->id }}" 
                                                                            data-current-role="{{ $user->role }}"
                                                                            style="width: auto; min-width: 120px; display: none;">
                                                                        @foreach($availableRoles as $roleName => $roleData)
                                                                            <option value="{{ $roleName }}" 
                                                                                    {{ $user->role === $roleName ? 'selected' : '' }}>
                                                                                {{ $roleName }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <button class="btn btn-sm btn-success ms-2 update-role-btn" 
                                                                            data-user-id="{{ $user->id }}" 
                                                                            style="display: none;">
                                                                        <i class="fas fa-check"></i>
                                                                    </button>
                                                                    <button class="btn btn-sm btn-secondary ms-1 cancel-role-btn" 
                                                                            data-user-id="{{ $user->id }}" 
                                                                            style="display: none;">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                @else
                                                                    <span class="text-muted small">(Cannot edit own role)</span>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-bs-toggle="dropdown">
                                                                    Actions
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    @if($user->id !== auth()->id())
                                                                        <a class="dropdown-item quick-edit-role" href="#" data-user-id="{{ $user->id }}">
                                                                            <i class="fas fa-user-edit"></i> Quick Edit Role
                                                                        </a>
                                                                    @endif
                                                                    <a class="dropdown-item" href="{{ route('admin.edit-user', $user->id) }}">
                                                                        <i class="fas fa-edit"></i> Edit Full Profile
                                                                    </a>
                                                                    @if($user->id !== auth()->id())
                                                                        <div class="dropdown-divider"></div>
                                                                        <form action="{{ route('admin.delete-user', $user->id) }}" method="POST" style="display: inline;">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                                                                                <i class="fas fa-trash"></i> Delete
                                                                            </button>
                                                                        </form>
                                                                    @endif
                                                                </div>
                                                            </div>
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

                    <!-- Role Permissions -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Role Permissions</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Role</th>
                                                    <th>Description</th>
                                                    <th>Permissions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($availableRoles as $roleName => $roleData)
                                                    <tr>
                                                        <td>
                                                            <span class="badge bg-{{
                                                                $roleName === 'Admin' ? 'danger' :
                                                                ($roleName === 'Vendor' ? 'info' :
                                                                ($roleName === 'Retailer' ? 'success' :
                                                                ($roleName === 'Supplier' ? 'warning' : 'secondary')))
                                                            }}">
                                                                {{ $roleName }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $roleData['description'] }}</td>
                                                        <td>
                                                            @foreach($roleData['permissions'] as $permission)
                                                                <span class="badge bg-light text-dark">{{ $permission }}</span>
                                                            @endforeach
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
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Updating role...</span>
                </div>
                <p class="mt-2 mb-0">Updating user role...</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    console.log('Role management page loaded');
    
    // Initialize DataTable
    $('.table').DataTable({
        "responsive": true,
        "autoWidth": false,
    });

    // Initialize Bootstrap dropdowns
    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl);
    });

    // Fallback dropdown functionality if Bootstrap doesn't work
    $('.dropdown-toggle').on('click', function(e) {
        e.preventDefault();
        const dropdownMenu = $(this).next('.dropdown-menu');
        console.log('Dropdown clicked, menu found:', dropdownMenu.length > 0);
        
        // Toggle dropdown manually if Bootstrap doesn't work
        if (dropdownMenu.length > 0) {
            dropdownMenu.toggleClass('show');
            $(this).attr('aria-expanded', dropdownMenu.hasClass('show'));
        }
    });

    // Close dropdowns when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.dropdown').length) {
            $('.dropdown-menu').removeClass('show');
            $('.dropdown-toggle').attr('aria-expanded', 'false');
        }
    });

    // Handle role selection change
    $('.role-select').on('change', function() {
        const userId = $(this).data('user-id');
        const currentRole = $(this).data('current-role');
        const newRole = $(this).val();
        
        console.log('Role changed for user', userId, 'from', currentRole, 'to', newRole);
        
        if (newRole !== currentRole) {
            // Show update and cancel buttons
            $(`.update-role-btn[data-user-id="${userId}"]`).show();
            $(`.cancel-role-btn[data-user-id="${userId}"]`).show();
        } else {
            // Hide update and cancel buttons
            $(`.update-role-btn[data-user-id="${userId}"]`).hide();
            $(`.cancel-role-btn[data-user-id="${userId}"]`).hide();
        }
    });

    // Handle role update
    $('.update-role-btn').on('click', function() {
        const userId = $(this).data('user-id');
        const roleSelect = $(`.role-select[data-user-id="${userId}"]`);
        const newRole = roleSelect.val();
        const currentRole = roleSelect.data('current-role');
        const userName = roleSelect.closest('tr').find('td:eq(1)').text(); // Get user name from second column
        
        // Check if user is trying to change their own role
        const currentUserId = {{ auth()->id() }};
        if (userId == currentUserId) {
            showAlert('warning', 'You cannot change your own role. Please ask another administrator to do this for you.');
            return;
        }
        
        // Show confirmation dialog
        let confirmMessage = `Are you sure you want to change ${userName}'s role from ${currentRole} to ${newRole}?`;
        
        // Extra warning for admin role changes
        if (currentRole === 'Admin' || newRole === 'Admin') {
            confirmMessage = `⚠️ WARNING: You are changing ${userName}'s role from ${currentRole} to ${newRole}. This will affect their system access. Are you sure?`;
        }
        
        if (!confirm(confirmMessage)) {
            return;
        }
        
        // Show loading modal
        const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
        loadingModal.show();
        
        // Send AJAX request
        $.ajax({
            url: `/admin/update-role/${userId}`,
            method: 'POST',
            data: {
                role: newRole,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Hide loading modal
                loadingModal.hide();
                
                if (response.success) {
                    // Update the current role data attribute
                    roleSelect.data('current-role', newRole);
                    
                    // Hide update and cancel buttons
                    $(`.update-role-btn[data-user-id="${userId}"]`).hide();
                    $(`.cancel-role-btn[data-user-id="${userId}"]`).hide();
                    
                    // Update the badge
                    const badge = roleSelect.siblings('.badge');
                    badge.removeClass().addClass(`badge bg-${getRoleColor(newRole)} me-2`);
                    badge.text(newRole);
                    
                    // Show success message
                    showAlert('success', response.message);
                    
                    // Refresh role statistics
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    // Show error message
                    showAlert('danger', response.message || 'Failed to update user role.');
                    
                    // Reset to original role
                    roleSelect.val(currentRole);
                    
                    // Hide update and cancel buttons
                    $(`.update-role-btn[data-user-id="${userId}"]`).hide();
                    $(`.cancel-role-btn[data-user-id="${userId}"]`).hide();
                }
            },
            error: function(xhr) {
                // Hide loading modal
                loadingModal.hide();
                
                // Reset to original role
                const currentRole = roleSelect.data('current-role');
                roleSelect.val(currentRole);
                
                // Hide update and cancel buttons
                $(`.update-role-btn[data-user-id="${userId}"]`).hide();
                $(`.cancel-role-btn[data-user-id="${userId}"]`).hide();
                
                // Show error message
                let errorMessage = 'Failed to update user role. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                showAlert('danger', errorMessage);
            }
        });
    });

    // Handle role update cancellation
    $('.cancel-role-btn').on('click', function() {
        const userId = $(this).data('user-id');
        const roleSelect = $(`.role-select[data-user-id="${userId}"]`);
        const currentRole = roleSelect.data('current-role');
        
        // Reset to original role
        roleSelect.val(currentRole);
        
        // Hide update and cancel buttons
        $(`.update-role-btn[data-user-id="${userId}"]`).hide();
        $(`.cancel-role-btn[data-user-id="${userId}"]`).hide();
    });

    // Handle quick edit role
    $('.quick-edit-role').on('click', function(e) {
        e.preventDefault();
        const userId = $(this).data('user-id');
        const roleSelect = $(`.role-select[data-user-id="${userId}"]`);
        
        console.log('Quick edit role clicked for user', userId);
        
        // Toggle visibility of role select
        if (roleSelect.is(':visible')) {
            roleSelect.hide();
            $(`.update-role-btn[data-user-id="${userId}"]`).hide();
            $(`.cancel-role-btn[data-user-id="${userId}"]`).hide();
        } else {
            roleSelect.show();
            // Focus on the select
            roleSelect.focus();
        }
    });

    // Helper function to get role color
    function getRoleColor(role) {
        switch(role) {
            case 'Admin': return 'danger';
            case 'Vendor': return 'info';
            case 'Retailer': return 'success';
            case 'Customer': return 'secondary';
            default: return 'secondary';
        }
    }

    // Helper function to show alerts
    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        // Remove existing alerts
        $('.alert').remove();
        
        // Add new alert at the top of the card body
        $('.card-body').prepend(alertHtml);
        
        // Auto-dismiss after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);
    }
});
</script>
@endpush

@push('styles')
<style>
.dropdown-menu.show {
    display: block !important;
    position: absolute !important;
    z-index: 1000 !important;
}

.btn-group .dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    display: none;
    float: left;
    min-width: 10rem;
    padding: 0.5rem 0;
    margin: 0.125rem 0 0;
    font-size: 0.875rem;
    color: #212529;
    text-align: left;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0, 0, 0, 0.15);
    border-radius: 0.375rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.175);
}

.btn-group .dropdown-menu.show {
    display: block;
}
</style>
@endpush 