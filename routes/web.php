<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\LogisticsDashboardController;
use App\Http\Controllers\AnalyticsDashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoleApprovalController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\VendorFormController;
use App\Http\Controllers\HelpController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin-dashboard', function () {
    return view('admin-dashboard');
});

Route::get('/dashboard', function () {
    return view('admin-dashboard');
})->middleware(['auth', 'verified', 'role'])->name('dashboard');

Route::get('/admin', function () {
    return view('admin-dashboard');
})->name('admin.dashboard');

Route::get('/application-status', [\App\Http\Controllers\Auth\ApplicationStatusController::class, 'index'])->name('application.status');

// Logistics Routes - Accessible by Admin and Logistics roles
Route::middleware(['auth', 'permission:manage_logistics,view_reports'])->group(function () {
    Route::get('/logistics/dashboard', [LogisticsDashboardController::class, 'index'])->name('logistics.dashboard');
    Route::put('/logistics/shipments/{shipment}/status', [LogisticsDashboardController::class, 'updateShipmentStatus'])->name('logistics.shipments.update-status');
    Route::get('/logistics/shipments/{shipment}', [LogisticsDashboardController::class, 'getShipmentDetails'])->name('logistics.shipments.show');
    // Add AJAX endpoints for dashboard interactivity
    Route::post('/logistics/shipments', [LogisticsDashboardController::class, 'store'])->name('logistics.shipments.store');
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

// Order Management Routes - Accessible by Admin, Vendor, Retailer, Customer
Route::middleware(['auth', 'permission:view_orders,create_orders,edit_orders'])->group(function () {
    Route::resource('orders', OrderController::class);
    Route::post('/orders/place', [OrderController::class, 'store'])->name('orders.place');
    Route::get('/orders/pending', [OrderController::class, 'pending'])->name('orders.pending');
    Route::get('/catalog', [OrderController::class, 'catalog'])->name('orders.catalog');
    Route::get('/orders/confirmation/{order}', [App\Http\Controllers\OrderController::class, 'confirmation'])->name('orders.confirmation');
});

// Profile Routes - Accessible by all authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Help Routes - Accessible by all authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/help', [HelpController::class, 'index'])->name('help.index');
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
    
    // Role approval routes
    Route::get('/admin/role-approvals', [RoleApprovalController::class, 'index'])->name('admin.role-approvals');
    Route::get('/admin/role-approvals/{roleApprovalRequest}', [RoleApprovalController::class, 'show'])->name('admin.role-approval.show');
    Route::post('/admin/role-approvals/{roleApprovalRequest}/approve', [RoleApprovalController::class, 'approve'])->name('admin.role-approval.approve');
    Route::post('/admin/role-approvals/{roleApprovalRequest}/reject', [RoleApprovalController::class, 'reject'])->name('admin.role-approval.reject');
    Route::get('/admin/role-approvals-stats', [RoleApprovalController::class, 'getStats'])->name('admin.role-approval.stats');
    Route::post('/admin/orders/bulk', [\App\Http\Controllers\AdminOrderController::class, 'bulk'])->name('admin.orders.bulk');
    Route::get('/admin/orders/export', [\App\Http\Controllers\AdminOrderController::class, 'export'])->name('admin.orders.export');
    Route::post('/admin/orders/{order}/admin-notes', [\App\Http\Controllers\AdminOrderController::class, 'updateAdminNotes'])->name('admin.orders.update-admin-notes');
    Route::get('/admin/orders/{order}/invoice', [\App\Http\Controllers\AdminOrderController::class, 'invoice'])->name('admin.orders.invoice');
    Route::post('/admin/orders/{order}/assign', [\App\Http\Controllers\AdminOrderController::class, 'updateAssignment'])->name('admin.orders.update-assignment');
});

// Chat routes (only for wholesalers and customers)
Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index')->middleware('role:Wholesaler,Customer');
    Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat.show')->middleware('role:Wholesaler,Customer');
    Route::post('/chat/{user}', [ChatController::class, 'store'])->name('chat.store')->middleware('role:Wholesaler,Customer');
});
Route::view('/vendor/apply', 'vendor.apply');
Route::post('/vendor/submit', [VendorFormController::class, 'submit']);

// Retailer Dashboard Route
Route::middleware(['auth', 'role:Retailer'])->group(function () {
    Route::get('/retailer/dashboard', [\App\Http\Controllers\RetailerDashboardController::class, 'index'])->name('retailer.dashboard');
});

// Retailer Wine Catalog Route
Route::middleware(['auth', 'role:Retailer'])->group(function () {
    Route::get('/retailer/catalog', [\App\Http\Controllers\RetailerCatalogController::class, 'index'])->name('orders.catalog');
});

// Reports Route - Accessible by authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
});

// Financial Reports Route - Accessible by all authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/financial-reports', [App\Http\Controllers\FinancialReportController::class, 'index'])->name('financial-reports.index');
});

require __DIR__.'/auth.php';

// Analytics Dashboard Routes - Accessible by Admin (add more roles/permissions as needed)
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/analytics/dashboard', [AnalyticsDashboardController::class, 'index'])->name('analytics.dashboard');
    Route::post('/predict-sales', [AnalyticsDashboardController::class, 'predictSales'])->name('predict.sales');
});

// Vendor Dashboard Route - Accessible only by Vendor role
Route::middleware(['auth', 'role:Vendor'])->group(function () {
    Route::get('/vendor/dashboard', [App\Http\Controllers\VendorDashboardController::class, 'index'])->name('vendor.dashboard');
});

// Vendor Orders Resource Routes - Accessible only by Vendor role
Route::middleware(['auth', 'role:Vendor'])->group(function () {
    Route::resource('vendor/orders', App\Http\Controllers\VendorOrderController::class)->names('vendor.orders');
});

// Vendor Finance Route - Accessible only by Vendor role
Route::middleware(['auth', 'role:Vendor'])->group(function () {
    Route::get('/vendor/finance', [App\Http\Controllers\VendorFinanceController::class, 'index'])->name('vendor.finance');
});

// Vendor Reports Route - Accessible only by Vendor role
Route::middleware(['auth', 'role:Vendor'])->group(function () {
    Route::get('/vendor/reports', [App\Http\Controllers\VendorReportController::class, 'index'])->name('vendor.reports');
});

// Vendor Messages Route - Accessible only by Vendor role
Route::middleware(['auth', 'role:Vendor'])->group(function () {
    Route::get('/vendor/messages', [App\Http\Controllers\VendorMessageController::class, 'index'])->name('vendor.messages');
});

// Vendor Contracts Route - Accessible only by Vendor role
Route::middleware(['auth', 'role:Vendor'])->group(function () {
    Route::get('/vendor/contracts', [App\Http\Controllers\VendorContractController::class, 'index'])->name('vendor.contracts');
});

// Wholesaler Dashboard Route - Accessible only by Wholesaler role
Route::middleware(['auth', 'role:Wholesaler'])->group(function () {
    Route::get('/wholesaler/dashboard', [App\Http\Controllers\WholesalerDashboardController::class, 'index'])->name('wholesaler.dashboard');
});

// Batch Management Routes - Accessible by all authenticated users
Route::middleware(['auth'])->group(function () {
    Route::resource('batches', App\Http\Controllers\BatchController::class);
});

// Pricing Management Route - Accessible by all authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/pricing', [App\Http\Controllers\PricingController::class, 'index'])->name('pricing.index');
});

// Compliance Document Management Routes - Accessible by all authenticated users
Route::middleware(['auth'])->group(function () {
    Route::resource('compliance-documents', App\Http\Controllers\ComplianceDocumentController::class);
});

// Customer Products Page - All products for customers
Route::middleware(['auth', 'role:Customer'])->group(function () {
    Route::get('/customer/products', [App\Http\Controllers\OrderController::class, 'catalog'])->name('customer.products');
});

// Customer Dashboard Route - Accessible only by Customer role
Route::middleware(['auth', 'role:Customer'])->group(function () {
    Route::get('/customer/dashboard', function () {
        return view('customer-dashboard');
    })->name('customer.dashboard');
});

// Customer Order History Page - Only customer's own orders
Route::middleware(['auth', 'role:Customer'])->group(function () {
    Route::get('/customer/orders', [App\Http\Controllers\OrderController::class, 'customerOrders'])->name('customer.orders');
});

// Customer Favorites Placeholder Page
Route::middleware(['auth', 'role:Customer'])->group(function () {
    Route::get('/customer/favorites', function () {
        return view('customer.favorites');
    })->name('customer.favorites');
});

// Blade test route
Route::get('/test-blade', function () {
    return view('test');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/orders/history', [App\Http\Controllers\OrderController::class, 'history'])->name('orders.history');
});

// Cart Routes - Authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout');
});
