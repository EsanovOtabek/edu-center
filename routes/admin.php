<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AdminController::class, 'index'])->name('index');
Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
Route::get('/profile', [AdminController::class, 'profile'])->name('profile');


Route::resource('teachers', TeacherController::class);
Route::resource('subjects', SubjectController::class)->except(['create', 'show', 'edit']);
