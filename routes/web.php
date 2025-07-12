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

use App\Http\Controllers\SalesController;

use Illuminate\Http\Request;
use App\Models\Workforce;
use App\Models\SupplyCentre;


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
Route::middleware(['auth', 'role:Admin,Logistics'])->group(function () {
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

// Procurement Routes - Accessible by Admin, Retailer, Vendor, Wholesaler
Route::middleware(['auth', 'role:Admin,Retailer,Vendor,Wholesaler'])->group(function () {
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
    Route::get('/orders/pending', [OrderController::class, 'pending'])->name('orders.pending');
    Route::get('/catalog', [OrderController::class, 'catalog'])->name('orders.catalog');
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
// Vendor routes (commented out due to missing controller)
// Route::view('/vendor/apply', 'vendor.apply');
// Route::post('/vendor/submit', [VendorFormController::class, 'submit']);

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

// Workforce Dashboard Route
Route::get('/workforce/dashboard', function () {
    $workforces = \App\Models\Workforce::with('supplyCentres')->get();
    $supplyCentres = \App\Models\SupplyCentre::with('workforces')->get();
    $total = $workforces->count();
    $assigned = $workforces->where('status', 'assigned')->count();
    $available = $workforces->where('status', 'available')->count();
    return view('workforce.dashboard', compact('workforces', 'supplyCentres', 'total', 'assigned', 'available'));
})->name('workforce.dashboard');

// Add Workforce
Route::post('/workforce', function(Request $request) {
    Workforce::create($request->only('name', 'role', 'status', 'contact'));
    return redirect()->back()->with('success', 'Workforce added!');
})->name('workforce.store');

// Add Supply Centre
Route::post('/supplycentre', function(Request $request) {
    SupplyCentre::create($request->only('name', 'location'));
    return redirect()->back()->with('success', 'Supply centre added!');
})->name('supplycentre.store');

// Assign Workforce to Supply Centre
Route::post('/workforce/assign', function(Request $request) {
    $workforce = Workforce::findOrFail($request->workforce_id);
    $workforce->supplyCentres()->syncWithoutDetaching([
        $request->supply_centre_id => ['assigned_at' => now()]
    ]);
    $workforce->supplyCentres()->updateExistingPivot($request->supply_centre_id, ['assigned_at' => now()]);
    $workforce->status = 'assigned';
    $workforce->save();
    return redirect()->back()->with('success', 'Workforce assigned!');
})->name('workforce.assign');

// Unassign Workforce from Supply Centre
Route::post('/workforce/unassign', function(Request $request) {
    $workforce = Workforce::findOrFail($request->workforce_id);
    $workforce->supplyCentres()->detach($request->supply_centre_id);
    // Optionally update status if no more assignments
    if ($workforce->supplyCentres()->count() == 0) {
        $workforce->status = 'available';
        $workforce->save();
    }
    return redirect()->back()->with('success', 'Workforce unassigned!');
})->name('workforce.unassign');

// Delete Workforce
Route::delete('/workforce/{id}', function($id) {
    Workforce::destroy($id);
    return redirect()->back()->with('success', 'Workforce deleted!');
})->name('workforce.delete');

// Delete Supply Centre
Route::delete('/supplycentre/{id}', function($id) {
    SupplyCentre::destroy($id);
    return redirect()->back()->with('success', 'Supply centre deleted!');
})->name('supplycentre.delete');

// Auto-Assign Workforce to Supply Centres with No Workers
Route::post('/workforce/auto-assign', function() {
    $availableWorkforce = \App\Models\Workforce::where('status', 'available')->get();
    $emptyCentres = \App\Models\SupplyCentre::doesntHave('workforces')->get();
    $assigned = 0;
    foreach ($emptyCentres as $centre) {
        $worker = $availableWorkforce->shift();
        if ($worker) {
            $worker->supplyCentres()->attach($centre->id, ['assigned_at' => now()]);
            $worker->status = 'assigned';
            $worker->save();
            $assigned++;
        } else {
            break;
        }
    }
    return redirect()->back()->with('success', $assigned . ' workforce assigned to empty supply centres.');
})->name('workforce.autoassign');


Route::get('/stakeholders', function (Request $request) {
    $view = $request->query('view', 'index');
    $id = $request->query('id');

    switch ($view) {
        case 'create':
            return view('stakeholders.create');
        case 'edit':
            if ($id) {
                $stakeholder = \App\Models\Stakeholder::findOrFail($id);
                return view('stakeholders.edit', compact('stakeholder'));
            }
            abort(404);
        case 'index':
        default:
            $stakeholders = \App\Models\Stakeholder::all();
            return view('stakeholders.index', compact('stakeholders'));
    }
})->name('stakeholders.unified');

// Store new stakeholder
Route::post('/stakeholders', function(Illuminate\Http\Request $request) {
    \App\Models\Stakeholder::create($request->only('name', 'email', 'role'));
    return redirect()->back()->with('success', 'Stakeholder added!');
})->name('stakeholders.store');

// Update stakeholder
Route::put('/stakeholders/{id}', function(Illuminate\Http\Request $request, $id) {
    $stakeholder = \App\Models\Stakeholder::findOrFail($id);
    $stakeholder->update($request->only('name', 'email', 'role'));
    return redirect()->back()->with('success', 'Stakeholder updated!');
})->name('stakeholders.update');

// Delete stakeholder
Route::delete('/stakeholders/{id}', function($id) {
    \App\Models\Stakeholder::destroy($id);
    return redirect()->back()->with('success', 'Stakeholder deleted!');
})->name('stakeholders.destroy');

// Save preferences
Route::post('/stakeholders/preferences', function(Illuminate\Http\Request $request) {
    // Save preferences logic here (customize as needed)
    // Example: \App\Models\Preference::updateOrCreate([...], [...]);
    return redirect()->back()->with('success', 'Preferences saved!');
})->name('stakeholders.preferences');

Route::post('/stakeholders/{id}/preferences', [App\Http\Controllers\StakeholderController::class, 'updatePreferences'])->name('stakeholders.preferences.update');

Route::get('/stakeholders/dashboard', [App\Http\Controllers\StakeholderController::class, 'dashboard'])->name('stakeholders.dashboard');

require __DIR__.'/auth.php';

// Analytics Dashboard Routes - Accessible by Admin (add more roles/permissions as needed)
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/analytics/dashboard', [AnalyticsDashboardController::class, 'index'])->name('analytics.dashboard');
    Route::post('/predict-sales', [AnalyticsDashboardController::class, 'predictSales'])->name('predict.sales');
});

Route::get('/workforce/assignments', [App\Http\Controllers\WorkforceDashboardController::class, 'assignments'])->name('workforce.assignments');

// Forecast Routes
Route::get('/forecast', [SalesController::class, 'dashboard'])->name('forecast.dashboard');
Route::post('/forecast/predict', [SalesController::class, 'predictCategory'])->name('forecast.predict');