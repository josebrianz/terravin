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
    $workforce->supplyCentres()->attach($request->supply_centre_id);
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
