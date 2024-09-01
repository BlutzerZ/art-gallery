<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserManagementController;

Route::get('/', function () {
    return view('welcome', [
        'title' => 'dashboard'
    ]);
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.showLogin');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard/user-management', [UserManagementController::class, 'show'])->name('userManagement.show');
    Route::post('/dashboard/user-management/edit', [UserManagementController::class, 'edit'])->name('userManagement.edit');
});