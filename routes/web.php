<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\LogisticsDashboardController;
<<<<<<< HEAD
use App\Http\Controllers\WorkforceDashboardController;
use App\Http\Controllers\StakeholderController;
=======
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ChatController;
>>>>>>> 8a6b044cd805dbf3a9cac9ff39fc956a4293c0b9
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin-dashboard', function () {
    return view('admin-dashboard');
});

Route::get('/dashboard', function () {
    return view('admin-dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin', function () {
    return view('admin-dashboard');
})->name('admin.dashboard');

// Logistics Routes - Accessible by Admin and Logistics roles
Route::middleware(['auth', 'permission:manage_logistics,view_reports'])->group(function () {
    Route::get('/logistics/dashboard', [LogisticsDashboardController::class, 'index'])->name('logistics.dashboard');
    Route::put('/logistics/shipments/{shipment}/status', [LogisticsDashboardController::class, 'updateShipmentStatus'])->name('logistics.shipments.update-status');
    Route::get('/logistics/shipments/{shipment}', [LogisticsDashboardController::class, 'getShipmentDetails'])->name('logistics.shipments.show');
});

// Inventory Routes - Accessible by Admin, Vendor, Retailer
Route::middleware(['auth', 'permission:manage_inventory,view_inventory'])->group(function () {
    Route::resource('inventory', InventoryController::class);
});

// Procurement Routes - Accessible by Admin, Retailer
Route::middleware(['auth', 'permission:manage_procurement,view_procurement'])->group(function () {
    Route::get('/procurement/dashboard', [ProcurementController::class, 'dashboard'])->name('procurement.dashboard');
    Route::resource('procurement', ProcurementController::class);
    
    // Procurement Status Management Routes
    Route::post('/procurement/{procurement}/approve', [ProcurementController::class, 'approve'])->name('procurement.approve');
    Route::post('/procurement/{procurement}/mark-as-ordered', [ProcurementController::class, 'markAsOrdered'])->name('procurement.markAsOrdered');
    Route::post('/procurement/{procurement}/mark-as-received', [ProcurementController::class, 'markAsReceived'])->name('procurement.markAsReceived');
});

// Order Management Routes - Accessible by Admin, Vendor, Customer
Route::middleware(['auth', 'permission:manage_orders,view_orders,create_orders'])->group(function () {
    Route::resource('orders', OrderController::class);
    Route::get('/orders/pending', [OrderController::class, 'pending'])->name('orders.pending');
    Route::get('/catalog', [OrderController::class, 'catalog'])->name('orders.catalog');
});

// Profile Routes - Accessible by all authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes - Accessible only by Admin role
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/manage-roles', [RoleController::class, 'index'])->name('admin.manage-roles');
    Route::post('/admin/update-role/{id}', [RoleController::class, 'updateUserRole'])->name('admin.update-role');
    Route::post('/admin/add-user', [RoleController::class, 'createUser'])->name('admin.add-user');
    Route::get('/admin/edit-user/{id}', [RoleController::class, 'editUser'])->name('admin.edit-user');
    Route::post('/admin/edit-user/{id}', [RoleController::class, 'updateUser'])->name('admin.update-user');
    Route::delete('/admin/delete-user/{id}', [RoleController::class, 'deleteUser'])->name('admin.delete-user');
    Route::get('/admin/users-by-role/{role}', [RoleController::class, 'getUsersByRole'])->name('admin.users-by-role');
    Route::get('/admin/role-stats', [RoleController::class, 'getRoleStats'])->name('admin.role-stats');
    
    // Admin user creation routes
    Route::get('/admin/create-user', [RegisteredUserController::class, 'createAdmin'])->name('admin.create-user');
    Route::post('/admin/create-user', [RegisteredUserController::class, 'storeAdmin'])->name('admin.store-user');
});

// Chat routes (only for suppliers and customers)
Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index')->middleware('role:Supplier,Customer');
    Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat.show')->middleware('role:Supplier,Customer');
    Route::post('/chat/{user}', [ChatController::class, 'store'])->name('chat.store')->middleware('role:Supplier,Customer');
});

require __DIR__.'/auth.php';
<<<<<<< HEAD

Route::get('/admin', function () {
    return view('admin-dashboard');
})->name('admin.dashboard');

Route::get('/logistics/dashboard', [LogisticsDashboardController::class, 'index'])->name('logistics.dashboard');

Route::resource('inventory', InventoryController::class);

// Procurement Routes
Route::get('/procurement/dashboard', [ProcurementController::class, 'dashboard'])->name('procurement.dashboard');
Route::resource('procurement', ProcurementController::class);

// Procurement Status Management Routes
Route::post('/procurement/{procurement}/approve', [ProcurementController::class, 'approve'])->name('procurement.approve');
Route::post('/procurement/{procurement}/mark-as-ordered', [ProcurementController::class, 'markAsOrdered'])->name('procurement.markAsOrdered');
Route::post('/procurement/{procurement}/mark-as-received', [ProcurementController::class, 'markAsReceived'])->name('procurement.markAsReceived');

// AJAX routes for dashboard functionality
Route::put('/logistics/shipments/{shipment}/status', [LogisticsDashboardController::class, 'updateShipmentStatus'])->name('logistics.shipments.update-status');
Route::get('/logistics/shipments/{shipment}', [LogisticsDashboardController::class, 'getShipmentDetails'])->name('logistics.shipments.show');

Route::get('/workforce/dashboard', [\App\Http\Controllers\WorkforceDashboardController::class, 'index'])->name('workforce.dashboard');
Route::post('/workforce/assign', [\App\Http\Controllers\WorkforceDashboardController::class, 'assign'])->name('workforce.assign');
Route::post('/workforce/unassign', [\App\Http\Controllers\WorkforceDashboardController::class, 'unassign'])->name('workforce.unassign');
Route::post('/workforce/store', [\App\Http\Controllers\WorkforceDashboardController::class, 'storeWorkforce'])->name('workforce.store');
Route::delete('/workforce/delete/{id}', [\App\Http\Controllers\WorkforceDashboardController::class, 'deleteWorkforce'])->name('workforce.delete');
Route::post('/supplycentre/store', [\App\Http\Controllers\WorkforceDashboardController::class, 'storeSupplyCentre'])->name('supplycentre.store');
Route::delete('/supplycentre/delete/{id}', [\App\Http\Controllers\WorkforceDashboardController::class, 'deleteSupplyCentre'])->name('supplycentre.delete');

Route::get('/stakeholders', [StakeholderController::class, 'index'])->name('stakeholders.index');
Route::get('/stakeholders/create', [StakeholderController::class, 'create'])->name('stakeholders.create');
Route::post('/stakeholders', [StakeholderController::class, 'store'])->name('stakeholders.store');
Route::get('/stakeholders/{id}/edit', [StakeholderController::class, 'edit'])->name('stakeholders.edit');
Route::put('/stakeholders/{id}', [StakeholderController::class, 'update'])->name('stakeholders.update');
Route::delete('/stakeholders/{id}', [StakeholderController::class, 'destroy'])->name('stakeholders.destroy');

// Preferences
Route::get('/stakeholders/{id}/preferences', [StakeholderController::class, 'preferences'])->name('stakeholders.preferences');
Route::post('/stakeholders/{id}/preferences', [StakeholderController::class, 'updatePreferences'])->name('stakeholders.preferences.update');
=======
>>>>>>> 8a6b044cd805dbf3a9cac9ff39fc956a4293c0b9
