<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\LogisticsDashboardController;
use App\Http\Controllers\WorkforceDashboardController;
use App\Http\Controllers\StakeholderController;
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

Route::get('/logistics/dashboard', [LogisticsDashboardController::class, 'index'])->name('logistics.dashboard');

Route::resource('inventory', InventoryController::class);

// Procurement Routes
Route::get('/procurement/dashboard', [ProcurementController::class, 'dashboard'])->name('procurement.dashboard');
Route::resource('procurement', ProcurementController::class);

// Procurement Status Management Routes
Route::post('/procurement/{procurement}/approve', [ProcurementController::class, 'approve'])->name('procurement.approve');
Route::post('/procurement/{procurement}/mark-as-ordered', [ProcurementController::class, 'markAsOrdered'])->name('procurement.markAsOrdered');
Route::post('/procurement/{procurement}/mark-as-received', [ProcurementController::class, 'markAsReceived'])->name('procurement.markAsReceived');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

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
