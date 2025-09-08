<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Asset
    Route::get('/assets/create', [AdminController::class, 'createAsset'])->name('assets.create');
    Route::post('/assets/store', [AdminController::class, 'storeAsset'])->name('assets.store');
    Route::post('/assets/{id}/return', [AdminController::class, 'returnAsset'])->name('assets.return'); // return from user
    Route::post('/assets/{id}/vendor-return', [AdminController::class, 'returnToVendor'])->name('assets.vendor_return'); // return to vendor
    Route::get('/assets/{id}/edit', [AdminController::class, 'editAsset'])->name('assets.edit');
    Route::put('/assets/{id}', [AdminController::class, 'updateAsset'])->name('assets.update');
    Route::delete('/assets/{id}', [AdminController::class, 'deleteAsset'])->name('assets.delete');

    // Vendors
    Route::get('/vendors/create', [AdminController::class, 'createVendor'])->name('vendors.create');
    Route::post('/vendors/store', [AdminController::class, 'storeVendor'])->name('vendors.store');
    Route::get('/vendors/{id}/edit', [AdminController::class, 'editVendor'])->name('vendors.edit');
    Route::put('/vendors/{id}', [AdminController::class, 'updateVendor'])->name('vendors.update');
    Route::delete('/vendors/{id}', [AdminController::class, 'deleteVendor'])->name('vendors.delete');

    // Assignments
    Route::get('/assignments/create', [AdminController::class, 'createAssignment'])->name('assignments.create');
    Route::post('/assignments/store', [AdminController::class, 'storeAssignment'])->name('assignments.store');
});


// User Routes
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::post('/acknowledge-asset/{id}', [UserController::class, 'acknowledgeAssignment'])->name('acknowledge.asset');
});
