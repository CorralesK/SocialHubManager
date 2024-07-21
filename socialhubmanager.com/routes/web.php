<?php

use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScheduleController;


// Schedules
Route::get('schedules', [ScheduleController::class, 'index']);

Route::get('schedules/create', [ScheduleController::class, 'create']);
Route::post('schedules', [ScheduleController::class, 'store']);

Route::get('schedules/{schedule}/edit', [ScheduleController::class, 'edit']);
Route::patch('schedules/{schedule}', [ScheduleController::class, 'update']);

Route::delete('schedules/{schedule}', [ScheduleController::class, 'destroy']);

// Register
Route::get('register', [RegisterController::class, 'create']);
Route::post('register', [RegisterController::class, 'store']);


Route::get('/', function () {
    return view('welcome');
});
