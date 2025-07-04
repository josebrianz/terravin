<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\LogisticsDashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\VendorFormController;
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
Route::middleware(['auth'])->group(function () {
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
Route::view('/vendor/apply', 'vendor.apply');
Route::post('/vendor/submit', [VendorFormController::class, 'submit']);

require __DIR__.'/auth.php';
