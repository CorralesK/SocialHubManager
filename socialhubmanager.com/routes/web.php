<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\TwoFactorController;

// Home
Route::get('/', [HomeController::class, 'index'])->middleware('user');

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

Route::get('logout', [SessionsController::class, 'destroy']);

// Activate Two factor authentication
Route::get('two-factor/activate', [TwoFactorController::class, 'create'])->middleware('user');
Route::post('two-factor/activate', [TwoFactorController::class, 'store'])->middleware('user');

// Deactivate Two factor authentication
Route::delete('two-factor/deactivate', [TwoFactorController::class, 'destroy'])->middleware('user');

// Verify OTP
Route::get('/two-factor/verify', [TwoFactorController::class, 'edit']);
Route::patch('/two-factor/verify', [TwoFactorController::class, 'update']);

// Connections with social medias
Route::get('auth/{provider}', [SocialController::class, 'redirect'])->middleware('user');
Route::get('auth/{provider}/callback', [SocialController::class, 'callback']);

Route::get('auth/{provider}/publish/{postId}', [SocialController::class, 'publishPost']);

// Post
Route::get('post/create', [PostController::class, 'create'])->middleware('user');
Route::post('post', [PostController::class,  'store'])->middleware('user');

Route::get('post/{post}/schedule', [PostController::class, 'schedule'])->middleware('user');
Route::patch('post/{post}/schedule', [PostController::class, 'updateScheduled'])->middleware('user');

Route::get('post/history', [PostController::class, 'index'])->middleware('user')->name('history');
