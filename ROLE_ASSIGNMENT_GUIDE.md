# Role Assignment Guide

This guide shows you all the different ways to assign roles to users in the TERRAVIN system.

## 🎯 **Where to Assign Roles**

### 1. **Admin Role Management Interface** (Primary Method)
**URL**: `/admin/manage-roles`  
**Access**: Admin role required

This is the main interface for managing users and their roles.

**Features**:
- ✅ View all users and their current roles
- ✅ Add new users with specific roles
- ✅ Edit existing users and change their roles
- ✅ Delete users
- ✅ View role statistics
- ✅ View role permissions matrix

**How to use**:
1. Login as an Admin user
2. Navigate to `/admin/manage-roles`
3. Use the "Add New User" form to create users with specific roles
4. Or edit existing users to change their roles

---

### 2. **User Registration** (Automatic Assignment)
**URL**: `/register`  
**Access**: Public

When users register through the public registration form, they are automatically assigned the **Customer** role.

**Default Role**: `Customer`

**How it works**:
```php
// In RegisteredUserController::store()
$user = User::create([
    'name' => $request->name,
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'role' => 'Customer', // Default role for new registrations
]);
```

---

### 3. **Admin User Creation** (Admin Interface)
**URL**: `/admin/create-user`  
**Access**: Admin role required

Admins can create users with specific roles through a dedicated interface.

**Features**:
- ✅ Create users with any role
- ✅ Role selection dropdown
- ✅ Validation and error handling

**How to use**:
1. Login as Admin
2. Navigate to `/admin/create-user`
3. Fill in user details and select role
4. Submit to create user with specified role

---

### 4. **Command Line** (For Setup)
**Command**: `php artisan user:create-admin`

Create admin users directly from the command line.

**Usage Examples**:
```bash
# Interactive mode
php artisan user:create-admin

# With parameters
php artisan user:create-admin --name="John Admin" --email="admin@example.com" --password="secure123"
```

**Interactive prompts**:
- Name
- Email
- Password (hidden input)

---

### 5. **Database Seeding** (For Development)
**Command**: `php artisan db:seed --class=UserSeeder`

Create users with specific roles during development.

**Example Seeder**:
```php
// database/seeders/UserSeeder.php
public function run()
{
    User::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
        'role' => 'Admin'
    ]);

    User::create([
        'name' => 'Manager User',
        'email' => 'manager@example.com',
        'password' => Hash::make('password'),
        'role' => 'Manager'
    ]);
}
```

---

### 6. **Tinker** (For Testing)
**Command**: `php artisan tinker`

Create users interactively for testing purposes.

**Example**:
```php
// Create admin user
User::create([
    'name' => 'Test Admin',
    'email' => 'testadmin@example.com',
    'password' => Hash::make('password'),
    'role' => 'Admin'
]);

// Create manager user
User::create([
    'name' => 'Test Manager',
    'email' => 'testmanager@example.com',
    'password' => Hash::make('password'),
    'role' => 'Manager'
]);
```

---

### 7. **API Endpoints** (For Integration)
**URL**: Various API endpoints  
**Access**: Based on middleware

If you have API endpoints, you can assign roles through API calls.

**Example**:
```php
// In your API controller
public function store(Request $request)
{
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role ?? 'Customer',
    ]);
    
    return response()->json($user, 201);
}
```

---

## 🔧 **Role Assignment Methods in Code**

### In Controllers
```php
// Direct assignment
$user->update(['role' => 'Admin']);

// Through form request
$user->update($request->validated());
```

### In Models
```php
// Using User model
User::where('id', $userId)->update(['role' => 'Manager']);

// Creating new user
User::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => Hash::make('password'),
    'role' => 'Vendor'
]);
```

### In Blade Templates
```php
{{-- Display role --}}
<span class="badge badge-{{ $user->getRoleColor() }}">
    {{ $user->getRoleDisplayName() }}
</span>

{{-- Check role --}}
@if($user->isAdmin())
    <div>Admin content</div>
@endif
```

---

## 📋 **Available Roles**

| Role | Description | Default Permissions |
|------|-------------|-------------------|
| **Admin** | Full system access | All permissions |
| **Manager** | Department management | Inventory, Orders, Procurement, Logistics, Reports |
| **Vendor** | Order management | View Orders, Update Order Status, View Inventory |
| **Supplier** | Procurement access | View Procurement, Update Procurement Status, View Inventory |
| **Customer** | Basic access | View Orders, Create Orders, View Inventory |

---

## 🚀 **Quick Start Guide**

### Step 1: Create Your First Admin User
```bash
# Run the command
php artisan user:create-admin

# Or with parameters
php artisan user:create-admin --name="Your Name" --email="your@email.com" --password="yourpassword"
```

### Step 2: Access Admin Interface
1. Login with your admin credentials
2. Navigate to `/admin/manage-roles`
3. Start managing users and roles

### Step 3: Create Additional Users
- Use the admin interface to create users with specific roles
- Or use the command line for quick setup
- Or let users register (they'll get Customer role by default)

---

## 🔒 **Security Considerations**

1. **Role Validation**: Only valid roles can be assigned
2. **Admin Protection**: Admins cannot delete their own accounts
3. **Permission Checks**: All sensitive operations check permissions
4. **Route Protection**: Routes are protected by middleware
5. **View Security**: Blade directives prevent unauthorized content

---

## 🛠 **Troubleshooting**

### Common Issues

**"Access denied" errors**:
- Check if user has required role/permission
- Verify middleware is applied correctly
- Check if role exists in database

**Role not showing in dropdown**:
- Ensure role is defined in `Role::getAvailableRoles()`
- Check if role is seeded in database
- Verify role name spelling

**Cannot access admin interface**:
- Ensure user has Admin role
- Check if user is authenticated
- Verify route is accessible

### Debug Commands
```bash
# Check user roles
php artisan tinker
User::all(['name', 'email', 'role']);

# Check role permissions
Role::all(['name', 'permissions']);

# Create test user
php artisan user:create-admin --name="Test" --email="test@test.com" --password="password"
```

---

## 📞 **Need Help?**

If you encounter issues with role assignment:

1. Check the error logs in `storage/logs/laravel.log`
2. Verify database migrations are run: `php artisan migrate`
3. Ensure roles are seeded: `php artisan db:seed --class=RoleSeeder`
4. Check user authentication status
5. Verify route permissions and middleware 