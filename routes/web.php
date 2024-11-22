<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DevController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
})->name('index');


Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'loginCheck']);
Route::get('logout', [AuthController::class, 'logout'])->name('logout');



Route::get('dev', [DevController::class, 'index'])->name('dev-console');
Route::get('artisan/db-seed', [DevController::class, 'dbSeed'])->name('artisan.db-seed');
Route::get('artisan/migrate', [DevController::class, 'migrate'])->name('artisan.migrate');
Route::get('artisan/migrate-fresh', [DevController::class, 'migrateFresh'])->name('artisan.migrate-fresh');
Route::get('artisan/clear', [DevController::class, 'clear'])->name('artisan.clear');


