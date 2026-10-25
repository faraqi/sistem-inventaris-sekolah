<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReturnLogController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard (Role-specific view via DashboardController)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile (Laravel Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Items Katalog (Available for both Admin and User)
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/{item}', [ItemController::class, 'show'])->whereNumber('item')->name('items.show');

    // Loans Peminjaman (Available for both Admin and User)
    Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
    Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');
    Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
    Route::get('/loans/{loan}', [LoanController::class, 'show'])->whereNumber('loan')->name('loans.show');

    // Admin Only Routes
    Route::middleware(['role:admin'])->group(function () {
        // Categories CRUD
        Route::resource('categories', CategoryController::class)->except(['show']);

        // Items Admin Management
        Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
        Route::post('/items', [ItemController::class, 'store'])->name('items.store');
        Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->whereNumber('item')->name('items.edit');
        Route::put('/items/{item}', [ItemController::class, 'update'])->whereNumber('item')->name('items.update');
        Route::delete('/items/{item}', [ItemController::class, 'destroy'])->whereNumber('item')->name('items.destroy');
        Route::post('/items/{id}/restore', [ItemController::class, 'restore'])->whereNumber('id')->name('items.restore');

        // Loans Admin Management
        Route::get('/loans/report', [LoanController::class, 'report'])->name('loans.report');
        Route::delete('/loans/{loan}', [LoanController::class, 'destroy'])->whereNumber('loan')->name('loans.destroy');

        // Return Logs Management
        Route::get('/returns', [ReturnLogController::class, 'index'])->name('returns.index');
        Route::get('/returns/create', [ReturnLogController::class, 'create'])->name('returns.create');
        Route::post('/returns', [ReturnLogController::class, 'store'])->name('returns.store');
        Route::get('/returns/{returnLog}', [ReturnLogController::class, 'show'])->whereNumber('returnLog')->name('returns.show');

        // Activity Logs
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity_logs.index');

        // User Management
        Route::resource('users', UserController::class)->except(['show']);
    });
});

require __DIR__.'/auth.php';
