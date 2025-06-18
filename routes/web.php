<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/logistics/dashboard', [App\Http\Controllers\LogisticsDashboardController::class, 'index'])->name('logistics.dashboard');
use App\Http\Controllers\InventoryController;

Route::resource('inventory', InventoryController::class);
