<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScheduleController;


// Schedules
Route::get('schedules', [ScheduleController::class, 'index']);

Route::get('schedules/create', [ScheduleController::class, 'create']);
Route::post('schedules', [ScheduleController::class, 'store']);

Route::get('schedules/{schedule}/edit', [ScheduleController::class, 'edit']);
Route::patch('schedules/{schedule}', [ScheduleController::class, 'update']);

Route::delete('schedules/{schedule}', [ScheduleController::class, 'destroy']);



Route::get('/', function () {
    return view('welcome');
});
