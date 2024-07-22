<?php

use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SessionsController;

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


Route::get('/', function () {
    return view('welcome');
})->middleware('user');
