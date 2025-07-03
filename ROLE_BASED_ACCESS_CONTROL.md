# Role-Based Access Control (RBAC) System

## Overview

This Laravel application implements a comprehensive Role-Based Access Control (RBAC) system that provides granular permission management for different user types in the TERRAVIN wine management system.

## User Roles

### 1. Admin
- **Description**: Full system access with complete administrative privileges
- **Permissions**:
  - `manage_users` - Create, edit, and delete users
  - `manage_roles` - Assign and modify user roles
  - `manage_inventory` - Full inventory management
  - `manage_orders` - Complete order management
  - `manage_procurement` - Full procurement control
  - `manage_logistics` - Complete logistics management
  - `view_reports` - Access to all system reports
  - `system_settings` - System configuration access

### 2. Vendor
- **Description**: Vendor access for order management and inventory viewing
- **Permissions**:
  - `view_orders` - View order details
  - `update_order_status` - Update order status
  - `view_inventory` - View inventory information

### 3. Retailer
- **Description**: Retailer access for procurement and inventory management
- **Permissions**:
  - `view_procurement` - View procurement requests
  - `update_procurement_status` - Update procurement status
  - `view_inventory` - View inventory information

### 4. Supplier
- **Description**: Supplier access for order fulfillment and shipment management
- **Permissions**:
  - `view_orders` - View order details
  - `update_order_status` - Update order status
  - `view_inventory` - View inventory information
  - `manage_shipments` - Manage shipment tracking and delivery

### 5. Customer
- **Description**: Basic customer access for order management
- **Permissions**:
  - `view_orders` - View their own orders
  - `create_orders` - Create new orders
  - `view_inventory` - View available inventory

## Implementation Details

### Database Structure

#### Users Table
- `role` column (string) - Stores the user's role

#### Roles Table
- `name` (string) - Role name
- `description` (text) - Role description
- `permissions` (json) - Array of permissions for the role

### Models

#### User Model (`app/Models/User.php`)
```php
// Role checking methods
$user->isAdmin();
$user->isVendor();
$user->isRetailer();
$user->isSupplier();
$user->isCustomer();

// Permission checking methods
$user->hasPermission('manage_users');
$user->hasAnyPermission(['manage_users', 'manage_roles']);
$user->hasAllPermissions(['manage_users', 'manage_roles']);

// Role display methods
$user->getRoleDisplayName();
$user->getRoleColor();
```

#### Role Model (`app/Models/Role.php`)
```php
// Check if role has permission
$role->hasPermission('manage_users');

// Get all available roles
Role::getAvailableRoles();
```

### Middleware

#### RoleMiddleware (`app/Http/Middleware/RoleMiddleware.php`)
- Checks if user has specific role(s)
- Usage: `middleware('role:Admin')` or `middleware('role:Admin,Manager')`

#### PermissionMiddleware (`app/Http/Middleware/PermissionMiddleware.php`)
- Checks if user has specific permission(s)
- Usage: `middleware('permission:manage_users')` or `middleware('permission:manage_users,manage_roles')`

### Blade Directives

The system provides convenient Blade directives for view-level access control:

```blade
{{-- Check specific role --}}
@role('Admin')
    <div>Admin only content</div>
@endrole

{{-- Check specific permission --}}
@permission('manage_users')
    <div>User management content</div>
@endpermission

{{-- Check any permission --}}
@anyPermission(['manage_users', 'manage_roles'])
    <div>Content for users with either permission</div>
@endanyPermission

{{-- Check all permissions --}}
@allPermissions(['manage_users', 'manage_roles'])
    <div>Content for users with both permissions</div>
@endallPermissions
```

## Route Protection

### Route-Level Protection
```php
// Protect routes by role
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/manage-roles', [RoleController::class, 'index']);
});

// Protect routes by permission
Route::middleware(['auth', 'permission:manage_inventory'])->group(function () {
    Route::resource('inventory', InventoryController::class);
});

// Multiple permissions
Route::middleware(['auth', 'permission:manage_orders,view_orders'])->group(function () {
    Route::resource('orders', OrderController::class);
});
```

### Controller-Level Protection
```php
public function index()
{
    // Check permissions in controller
    if (!auth()->user()->hasPermission('manage_inventory')) {
        abort(403, 'Access denied.');
    }
    
    // Controller logic here
}
```

## Admin Interface

### Role Management (`/admin/manage-roles`)
- View all users with their current roles
- Add new users with specific roles
- Edit existing users and their roles
- Delete users (with safety checks)
- View role statistics
- View role permissions matrix

### Features
- **User Management**: Create, edit, and delete users
- **Role Assignment**: Assign roles to users
- **Statistics**: View user distribution by role
- **Permission Overview**: See what permissions each role has

## Usage Examples

### In Controllers
```php
public function store(Request $request)
{
    // Check if user can manage inventory
    if (!auth()->user()->hasPermission('manage_inventory')) {
        return redirect()->back()->with('error', 'Insufficient permissions.');
    }
    
    // Create inventory item
    Inventory::create($request->validated());
    
    return redirect()->route('inventory.index')->with('success', 'Item created successfully.');
}
```

### In Views
```blade
{{-- Show different content based on role --}}
@role('Admin')
    <div class="admin-panel">
        <h3>Admin Controls</h3>
        <a href="{{ route('admin.manage-roles') }}" class="btn btn-primary">Manage Roles</a>
    </div>
@endrole

@role('Manager')
    <div class="manager-panel">
        <h3>Manager Dashboard</h3>
        <a href="{{ route('inventory.index') }}" class="btn btn-info">Manage Inventory</a>
    </div>
@endrole

{{-- Show content based on permissions --}}
@permission('manage_orders')
    <div class="order-management">
        <h3>Order Management</h3>
        <a href="{{ route('orders.create') }}" class="btn btn-success">Create Order</a>
    </div>
@endpermission
```

### In Navigation
```blade
{{-- Include the role-based navigation component --}}
@include('components.role-based-nav')
```

## Security Features

1. **Route Protection**: All sensitive routes are protected by middleware
2. **Permission Validation**: Controllers validate permissions before executing actions
3. **View-Level Security**: Blade directives prevent unauthorized content display
4. **Admin Safety**: Admins cannot delete their own accounts
5. **Role Validation**: Only valid roles can be assigned to users

## Adding New Roles

To add a new role:

1. **Update Role Model**: Add the new role to `Role::getAvailableRoles()`
2. **Update User Model**: Add role checking method if needed
3. **Update Middleware**: Ensure middleware handles the new role
4. **Update Views**: Add role-specific content using Blade directives
5. **Update Routes**: Apply appropriate middleware to new routes

## Adding New Permissions

To add a new permission:

1. **Update Role Model**: Add permission to relevant roles in `getAvailableRoles()`
2. **Update Routes**: Apply permission middleware to relevant routes
3. **Update Controllers**: Add permission checks in controller methods
4. **Update Views**: Use `@permission` directive for new permission

## Best Practices

1. **Principle of Least Privilege**: Only grant necessary permissions
2. **Regular Audits**: Periodically review user roles and permissions
3. **Documentation**: Keep role and permission documentation updated
4. **Testing**: Test access control thoroughly for each role
5. **Monitoring**: Log access attempts and permission changes

## Troubleshooting

### Common Issues

1. **403 Forbidden Errors**: Check if user has required permissions
2. **Middleware Not Working**: Ensure middleware is registered in `Kernel.php`
3. **Blade Directives Not Working**: Check if directives are registered in `AppServiceProvider`
4. **Role Not Found**: Ensure role exists in database and is properly seeded

### Debugging

```php
// Check user's current role
dd(auth()->user()->role);

// Check user's permissions
dd(auth()->user()->roleModel()->permissions);

// Check if user has specific permission
dd(auth()->user()->hasPermission('manage_users'));
```

## Migration and Seeding

```bash
# Run migrations
php artisan migrate

# Seed roles
php artisan db:seed --class=RoleSeeder

# Create admin user (if needed)
php artisan tinker
User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => Hash::make('password'), 'role' => 'Admin']);
``` 