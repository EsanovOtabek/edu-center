<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AdminController::class, 'index'])->name('index');
Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
