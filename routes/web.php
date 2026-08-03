<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PhotoboxController;

// Auth Routes
Route::get('/login', [AuthController::class, 'showAuthForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [PhotoboxController::class, 'landing'])->name('landing');
Route::get('/studio', [PhotoboxController::class, 'index'])->name('workspace');

// Actions (Authentication checked dynamically inside controllers for guest support)
Route::post('/frame/save', [PhotoboxController::class, 'saveFrame'])->name('frame.save');
Route::delete('/frame/delete/{id}', [PhotoboxController::class, 'deleteFrame'])->name('frame.delete');
Route::post('/creation/save', [PhotoboxController::class, 'saveCreation'])->name('creation.save');
Route::delete('/creation/delete/{id}', [PhotoboxController::class, 'deleteCreation'])->name('creation.delete');
