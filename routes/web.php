<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin-dashboard');
});

Route::get('/admin', function () {
    return view('admin-dashboard');
})->name('admin.dashboard');

Route::get('/logistics/dashboard', [App\Http\Controllers\LogisticsDashboardController::class, 'index'])->name('logistics.dashboard');
use App\Http\Controllers\InventoryController;

Route::resource('inventory', InventoryController::class);

// Procurement Routes
use App\Http\Controllers\ProcurementController;

Route::get('/procurement/dashboard', [ProcurementController::class, 'dashboard'])->name('procurement.dashboard');
Route::resource('procurement', ProcurementController::class);

// Procurement Status Management Routes
Route::post('/procurement/{procurement}/approve', [ProcurementController::class, 'approve'])->name('procurement.approve');
Route::post('/procurement/{procurement}/mark-as-ordered', [ProcurementController::class, 'markAsOrdered'])->name('procurement.markAsOrdered');
Route::post('/procurement/{procurement}/mark-as-received', [ProcurementController::class, 'markAsReceived'])->name('procurement.markAsReceived');
