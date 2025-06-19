<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\LogisticsDashboardController;

Route::get('/', function () {
    return view('admin-dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
