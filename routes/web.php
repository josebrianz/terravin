<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\LogisticsDashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ChatController;
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

Route::get('/supplier-dashboard', function () {
    return view('supplier-dashboard');
})->name('supplier.dashboard');

Route::get('/vendor-dashboard', function () {
    return view('vendor-dashboard');
})->name('vendor.dashboard');

Route::get('/customer-dashboard', function () {
    return view('customer-dashboard');
})->middleware(['auth', 'role:Customer'])->name('customer.dashboard');

Route::get('/retailer-dashboard', [\App\Http\Controllers\RetailerDashboardController::class, 'index'])
    ->middleware(['auth', 'role:Retailer'])
    ->name('retailer.dashboard');

Route::get('/retailer/orders', [\App\Http\Controllers\RetailerDashboardController::class, 'orders'])
    ->middleware(['auth', 'role:Retailer'])
    ->name('retailer.orders');

Route::get('/retailer/orders/{id}', [\App\Http\Controllers\RetailerDashboardController::class, 'showOrder'])
    ->middleware(['auth', 'role:Retailer'])
    ->name('retailer.orders.show');

// Logistics Routes - Accessible only by Admin
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/logistics/dashboard', [LogisticsDashboardController::class, 'index'])->name('logistics.dashboard');
    Route::put('/logistics/shipments/{shipment}/status', [LogisticsDashboardController::class, 'updateShipmentStatus'])->name('logistics.shipments.update-status');
    Route::get('/logistics/shipments/{shipment}', [LogisticsDashboardController::class, 'getShipmentDetails'])->name('logistics.shipments.show');
});

// Inventory Routes - Accessible only by Admin
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::resource('inventory', InventoryController::class);
});

// Procurement Routes - Accessible only by Admin
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/procurement/dashboard', [ProcurementController::class, 'dashboard'])->name('procurement.dashboard');
    Route::resource('procurement', ProcurementController::class);
    
    // Procurement Status Management Routes
    Route::post('/procurement/{procurement}/approve', [ProcurementController::class, 'approve'])->name('procurement.approve');
    Route::post('/procurement/{procurement}/mark-as-ordered', [ProcurementController::class, 'markAsOrdered'])->name('procurement.markAsOrdered');
    Route::post('/procurement/{procurement}/mark-as-received', [ProcurementController::class, 'markAsReceived'])->name('procurement.markAsReceived');
});

// Order Management Routes - Accessible only by Admin
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::resource('orders', OrderController::class);
    Route::get('/orders/pending', [OrderController::class, 'pending'])->name('orders.pending');
});

// Profile Routes - Accessible by all authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/catalog', [OrderController::class, 'catalog'])->name('orders.catalog');
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

// Chat routes (only for suppliers)
Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index')->middleware('role:Supplier,Vendor');
    Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat.show')->middleware('role:Supplier,Vendor');
    Route::post('/chat/{user}', [ChatController::class, 'store'])->name('chat.store')->middleware('role:Supplier,Vendor');
});

Route::middleware(['auth', 'role:Retailer'])->group(function () {
    Route::get('/cart', [\App\Http\Controllers\OrderController::class, 'cart'])->name('cart.view');
    Route::post('/cart/add/{id}', [\App\Http\Controllers\OrderController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/remove/{id}', [\App\Http\Controllers\OrderController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/increase/{id}', [\App\Http\Controllers\OrderController::class, 'increaseCartItem'])->name('cart.increase');
    Route::post('/cart/decrease/{id}', [\App\Http\Controllers\OrderController::class, 'decreaseCartItem'])->name('cart.decrease');
    Route::post('/cart/clear', [\App\Http\Controllers\OrderController::class, 'clearCart'])->name('cart.clear');
    Route::get('/cart/checkout', [\App\Http\Controllers\OrderController::class, 'checkout'])->name('cart.checkout');
    Route::post('/cart/checkout', [\App\Http\Controllers\OrderController::class, 'processCheckout'])->name('cart.processCheckout');
    Route::get('/retailer/invoices', [App\Http\Controllers\RetailerDashboardController::class, 'invoices'])->name('retailer.invoices');
    Route::get('/retailer/notifications', [App\Http\Controllers\RetailerDashboardController::class, 'allNotifications'])->name('retailer.notifications');
    Route::post('/retailer/notifications/{id}/read', [App\Http\Controllers\RetailerDashboardController::class, 'markNotificationRead'])->name('retailer.notifications.read');
});

require __DIR__.'/auth.php';
