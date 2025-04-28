<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ActivityLogController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'store']);
Route::post('register', [AuthController::class, 'register'])->name('register');

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('posts', PostController::class);
Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
