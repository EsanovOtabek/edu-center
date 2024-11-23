<?php

use App\Http\Controllers\RoomController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AdminController::class, 'index'])->name('index');
Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
Route::get('/profile', [AdminController::class, 'profile'])->name('profile');


Route::resource('teachers', TeacherController::class);
Route::resource('subjects', controller: SubjectController::class)->except(['create', 'show', 'edit']);
Route::resource('rooms', RoomController::class)->except(['create', 'show', 'edit']);
Route::resource('groups', GroupController::class);


Route::get('/check-schedule-start', [ScheduleController::class, 'checkScheduleStart'])->name('check.schedule.start');
Route::get('/check-schedule-end', [ScheduleController::class, 'checkScheduleEnd'])->name('check.schedule.end');
Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');
