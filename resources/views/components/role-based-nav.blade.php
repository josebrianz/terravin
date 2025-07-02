<!-- Role-based Navigation Component -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('dashboard') }}">TERRAVIN</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <!-- Dashboard - All authenticated users -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>

                <!-- Inventory - Admin only -->
                @role('Admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('inventory.index') }}">
                        <i class="fas fa-boxes"></i> Inventory
                    </a>
                </li>
                @endrole

                <!-- Orders - Admin only -->
                @role('Admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('orders.index') }}">
                        <i class="fas fa-shopping-cart"></i> Orders
                    </a>
                </li>
                @endrole

                <!-- Procurement - Admin only -->
                @role('Admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('procurement.dashboard') }}">
                        <i class="fas fa-truck"></i> Procurement
                    </a>
                </li>
                @endrole

                <!-- Logistics - Admin only -->
                @role('Admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logistics.dashboard') }}">
                        <i class="fas fa-route"></i> Logistics
                    </a>
                </li>
                @endrole

                <!-- Chat - Suppliers and Customers only -->
                @if(Auth::user()->role === 'Supplier' || Auth::user()->role === 'Customer')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('chat.index') }}">
                        <i class="fas fa-comments"></i> Chat
                    </a>
                </li>
                @endif

                <!-- Admin Section - Admin only -->
                @role('Admin')
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-cog"></i> Admin
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('admin.manage-roles') }}">
                            <i class="fas fa-users-cog"></i> Manage Roles
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('admin.role-stats') }}">
                            <i class="fas fa-chart-bar"></i> Role Statistics
                        </a>
                    </div>
                </li>
                @endrole
            </ul>

            <!-- User Menu -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user"></i> {{ Auth::user()->name }}
                        <span class="badge bg-{{ Auth::user()->getRoleColor() }} ms-1">
                            {{ Auth::user()->getRoleDisplayName() }}
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        @if(Auth::user()->role === 'Supplier' || Auth::user()->role === 'Customer')
                        <a class="dropdown-item" href="{{ route('chat.index') }}">
                            <i class="fas fa-comments"></i> Chat
                        </a>
                        <div class="dropdown-divider"></div>
                        @endif
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="fas fa-user-edit"></i> Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        
                        <!-- Show permissions for current user -->
                        <div class="dropdown-header">
                            <small class="text-muted">Your Permissions:</small>
                        </div>
                        @php
                            $roleModel = Auth::user()->roleModel();
                            $permissions = $roleModel ? $roleModel->permissions : [];
                        @endphp
                        @foreach($permissions as $permission)
                            <div class="dropdown-item-text">
                                <small class="text-muted">
                                    <i class="fas fa-check text-success"></i> {{ $permission }}
                                </small>
                            </div>
                        @endforeach
                        
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav> 