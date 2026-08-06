<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PhotoboxController;

use App\Http\Controllers\DashboardController;

// Auth Routes
Route::get('/login', [AuthController::class, 'showAuthForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [PhotoboxController::class, 'landing'])->name('landing');
Route::get('/studio', [PhotoboxController::class, 'index'])->name('workspace');
Route::get('/studio/custom', [PhotoboxController::class, 'customStudio'])->name('studio.custom')->middleware('auth');
Route::get('/gallery/category/{slug}', [PhotoboxController::class, 'categoryTemplates'])->name('gallery.category');
Route::post('/studio/custom/upload', [PhotoboxController::class, 'uploadFromGallery'])->name('studio.custom.upload')->middleware('auth');

// Actions (Authentication checked dynamically inside controllers for guest support)
Route::post('/frame/save', [PhotoboxController::class, 'saveFrame'])->name('frame.save');
Route::delete('/frame/delete/{id}', [PhotoboxController::class, 'deleteFrame'])->name('frame.delete');
Route::post('/creation/save', [PhotoboxController::class, 'saveCreation'])->name('creation.save');
Route::delete('/creation/delete/{id}', [PhotoboxController::class, 'deleteCreation'])->name('creation.delete');

// Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
    Route::post('/dashboard/profile', [DashboardController::class, 'profileUpdate'])->name('dashboard.profile.update');
    Route::get('/dashboard/settings', [DashboardController::class, 'settings'])->name('dashboard.settings');
    Route::post('/dashboard/settings', [DashboardController::class, 'settingsUpdate'])->name('dashboard.settings.update');
    Route::get('/dashboard/users', [DashboardController::class, 'users'])->name('dashboard.users');
    Route::post('/dashboard/users', [DashboardController::class, 'userStore'])->name('dashboard.users.store');
    Route::post('/dashboard/users/{id}', [DashboardController::class, 'userUpdate'])->name('dashboard.users.update');
    Route::delete('/dashboard/users/{id}', [DashboardController::class, 'userDelete'])->name('dashboard.users.delete');
    Route::get('/dashboard/templates', [DashboardController::class, 'templates'])->name('dashboard.templates');
    Route::post('/dashboard/templates', [DashboardController::class, 'templateStore'])->name('dashboard.templates.store');
    Route::post('/dashboard/templates/{id}', [DashboardController::class, 'templateUpdate'])->name('dashboard.templates.update');
    Route::delete('/dashboard/templates/{id}', [DashboardController::class, 'templateDelete'])->name('dashboard.templates.delete');
    Route::get('/dashboard/backup', [PhotoboxController::class, 'backupDatabase'])->name('dashboard.backup');
    Route::get('/dashboard/logs', [PhotoboxController::class, 'activityLogs'])->name('dashboard.logs');
    Route::get('/dashboard/trash', [DashboardController::class, 'trash'])->name('dashboard.trash');
    Route::post('/dashboard/trash/restore/{type}/{id}', [DashboardController::class, 'restore'])->name('dashboard.trash.restore');
    Route::delete('/dashboard/trash/delete/{type}/{id}', [DashboardController::class, 'forceDelete'])->name('dashboard.trash.force_delete');
    Route::get('/dashboard/permissions', [DashboardController::class, 'permissions'])->name('dashboard.permissions');
    Route::post('/dashboard/permissions', [DashboardController::class, 'permissionsUpdate'])->name('dashboard.permissions.update');
});
