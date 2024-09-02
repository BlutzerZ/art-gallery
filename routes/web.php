<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ManageParticipantsController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\GalleryController;
use App\Models\Favorite;

Route::get('/', [FrontController::class, 'index'])->name('front');
Route::get('/show/{id}', [FrontController::class, 'show'])->name('show');
Route::get('/favorite', [FavoriteController::class, 'index'])->name('favorite');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.showLogin');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Route::middleware(['auth', 'role:organizer'])->group(function() {
Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard/user-management', [UserManagementController::class, 'index'])->name('userManagement.index');
    Route::post('/dashboard/user-management/edit', [UserManagementController::class, 'edit'])->name('userManagement.edit');

    Route::resource('/dashboard/manage-participants', ManageParticipantsController::class);
});

// Route::middleware(['auth', 'role:participant'])->group(function() {
Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard/gallery', [GalleryController::class, 'index'])->name('gallery.index');
    // Route::get('/dashboard/gallery/show/{id}', [GalleryController::class, 'show'])->name('gallery.show');
    Route::get('/dashboard/gallery/create', [GalleryController::class, 'create'])->name('gallery.create');
    Route::post('/dashboard/gallery/create', [GalleryController::class, 'store'])->name('gallery.store');
    Route::get('/dashboard/gallery/edit/{id}', [GalleryController::class, 'edit'])->name('gallery.edit');
    Route::put('/dashboard/gallery/edit/{id}', [GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/dashboard/gallery/delete/{id}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
    Route::post('/favorite', [FavoriteController::class, 'store'])->name('gallery.favorite');
});