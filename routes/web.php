<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BalanceController;

// Default Laravel welcome page route
Route::get('/', function () {
    return view('welcome');
});

// Dashboard route
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication routes
require __DIR__.'/auth.php';

// Balance routes
Route::middleware('auth')->group(function () {
    Route::post('/balance/update', [BalanceController::class, 'update'])->name('balance.update');
    Route::get('/balance/chart', [BalanceController::class, 'showChart'])->name('balance.chart');
});
