<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ServiceRecordController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::resource('workers', WorkerController::class)
    ->middleware(['auth', 'verified']);

Route::resource('services', ServiceController::class)
    ->middleware(['auth', 'verified']);

Route::resource('payment-methods', PaymentMethodController::class)
    ->middleware(['auth', 'verified']);

Route::resource('service-records', ServiceRecordController::class)
    ->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
