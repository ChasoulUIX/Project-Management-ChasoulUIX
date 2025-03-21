<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::resource('projects', ProjectController::class);
    Route::get('projects/{project}/payments/create', [PaymentController::class, 'create'])->name('projects.payments.create');
    Route::post('projects/{project}/payments', [PaymentController::class, 'store'])->name('projects.payments.store');
    Route::delete('projects/{project}/payments/{payment}', [PaymentController::class, 'destroy'])->name('projects.payments.destroy');
    
    Route::resource('teams', TeamController::class);
    Route::patch('teams/{team}/mark-as-paid', [TeamController::class, 'markAsPaid'])->name('teams.mark-as-paid');
    Route::patch('teams/{team}/projects/{project}/payment-status', [TeamController::class, 'updatePaymentStatus'])
        ->name('teams.update-payment-status');
    Route::post('/teams/{team}/projects', [TeamController::class, 'addProject'])
        ->name('teams.add-project');
    Route::patch('teams/{team}/projects/{project}/mark-as-paid', [TeamController::class, 'markProjectAsPaid'])
        ->name('teams.mark-project-as-paid');
    
    Route::resource('clients', ClientController::class);
});
