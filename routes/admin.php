<?php

use App\Http\Controllers\RoomController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ExpenseController;

use Illuminate\Support\Facades\Route;


Route::get('/', [AdminController::class, 'index'])->name('index');
Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
Route::get('/profile', [AdminController::class, 'profile'])->name('profile');


Route::resource('teachers', TeacherController::class);
Route::post('teachers/{id}/salary', [TeacherController::class, 'giveSalary'])->name('teachers.giveSalary');
Route::post('teachers/{id}/advance', [TeacherController::class, 'giveAdvance'])->name('teachers.giveAdvance');




Route::resource('subjects', controller: SubjectController::class)->except(['create', 'show', 'edit']);
Route::resource('rooms', RoomController::class)->except(['create', 'edit']);
Route::resource('groups', GroupController::class);
Route::post('/groups/{group}/remove-student', [GroupController::class, 'removeStudent'])->name('removeStudentGroup');
Route::post('/groups/{group}/add-student', [GroupController::class, 'addStudent'])->name('addStudentGroup');
Route::get('/groups/{group}/available-students', action: [GroupController::class, 'getAvailableStudents'])->name('getAvailableStudents');
Route::get('groups/{group}/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
Route::get('attendances', [AttendanceController::class, 'index'])->name('attendances.index');
Route::post('groups/{group}/attendance', [AttendanceController::class, 'saveAttendance'])->name('attendance.save');


Route::get('/check-schedule-start', [ScheduleController::class, 'checkScheduleStart'])->name('check.schedule.start');
Route::get('/check-schedule-update', [ScheduleController::class, 'checkScheduleUpdate'])->name('check.schedule.update');
Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');

Route::get('/payment/create', [PaymentController::class, 'create'])->name('payment.create');
Route::post('/payment/create', [PaymentController::class, 'store'])->name('payment.store');
Route::get('/payment/index', [PaymentController::class, 'index'])->name('payment.index');
Route::get('/payments/groups-by-student', [PaymentController::class, 'getGroupsByStudent'])->name('payment.getGroupsByStudent');


Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
Route::post('/expenses/create', [ExpenseController::class, 'store'])->name('expenses.store');
Route::get('/expenses/index', [ExpenseController::class, 'index'])->name('expenses.index');
Route::get('/expensess/groups-by-student', [ExpenseController::class, 'getGroupsByStudent'])->name('expenses.getGroupsByStudent');


Route::resource('students', StudentController::class);

