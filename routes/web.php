<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SpkController;
use App\Http\Controllers\MekanikController;
use App\Http\Controllers\BodyController;
use App\Http\Controllers\PreparationController;
use App\Http\Controllers\PaintController;
use App\Http\Controllers\PolesController;
use App\Http\Controllers\SparepartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Grup route untuk user yang sudah login
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Customers
    Route::get('/customers/{customer}/report', [CustomerController::class, 'report'])->name('customers.report');
    Route::resource('customers', CustomerController::class);

    // SPK
    // 1. Definisikan Route Custom (report) TERLEBIH DAHULU
    Route::get('/spk/{spk}/report', [SpkController::class, 'report'])->name('spk.report');
    Route::resource('spk', SpkController::class);
    
    // Sparepart
    Route::get('sparepart-report', [SparepartController::class, 'report'])->name('sparepart.report');
    Route::resource('sparepart', SparepartController::class);
    
    // Mekanik
    Route::get('/mekanik/{id}/report', [MekanikController::class, 'report'])->name('mekanik.report');
    Route::resource('mekanik', MekanikController::class);
    
    // Body
    Route::resource('body', BodyController::class);
    Route::get('body/{id}/report', [BodyController::class, 'report'])->name('body.report');

    // Preparation
    Route::resource('preparation', PreparationController::class);
    Route::get('preparation/{id}/report', [PreparationController::class, 'report'])->name('preparation.report');

    // Paint
    Route::resource('paint', PaintController::class);
    Route::get('paint/{id}/report', [PaintController::class, 'report'])->name('paint.report');

    // Poles
    Route::resource('poles', PolesController::class);
    Route::get('poles/{id}/report', [PolesController::class, 'report'])->name('poles.report');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';