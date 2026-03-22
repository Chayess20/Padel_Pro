<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public auth endpoints
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);
Route::post('/logout',   [AuthController::class, 'logout']);
Route::get('/session',   [AuthController::class, 'session']);

// Protected player endpoints
Route::middleware('auth')->group(function () {
    Route::get('/profile',         [ProfileController::class, 'show']);
    Route::post('/update-profile', [ProfileController::class, 'update']);
});
