<?php

use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\TwoFactorController;

// Schedules
Route::get('schedules', [ScheduleController::class, 'index'])->middleware('user');

Route::get('schedules/create', [ScheduleController::class, 'create'])->middleware('user');
Route::post('schedules', [ScheduleController::class, 'store'])->middleware('user');

Route::get('schedules/{schedule}/edit', [ScheduleController::class, 'edit'])->middleware('user');
Route::patch('schedules/{schedule}', [ScheduleController::class, 'update'])->middleware('user');

Route::delete('schedules/{schedule}', [ScheduleController::class, 'destroy'])->middleware('user');

// Register
Route::get('register', [RegisterController::class, 'create']);
Route::post('register', [RegisterController::class, 'store']);

// Login
Route::get('login', [SessionsController::class, 'create']);
Route::post('login', [SessionsController::class, 'store']);

Route::post('logout', [SessionsController::class, 'destroy']);

// Activate Two factor authentication
Route::get('two-factor/activate', [TwoFactorController::class, 'create'])->middleware('user');
Route::post('two-factor/activate', [TwoFactorController::class, 'store'])->middleware('user');;

// Verify OTP


Route::get('/', function () {
    return view('welcome');
})->middleware('user');
