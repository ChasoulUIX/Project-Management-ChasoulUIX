<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\PaymentController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.app.dashboard');
    })->name('dashboard');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::resource('projects', ProjectController::class);
    Route::get('projects/{project}/payments/create', [PaymentController::class, 'create'])->name('projects.payments.create');
    Route::post('projects/{project}/payments', [PaymentController::class, 'store'])->name('projects.payments.store');
    Route::delete('projects/{project}/payments/{payment}', [PaymentController::class, 'destroy'])->name('projects.payments.destroy');
});
