<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\TournamentController;
use Illuminate\Support\Facades\Route;

// Public auth endpoints
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:10,1');
Route::post('/login',    [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::post('/logout',   [AuthController::class, 'logout']);
Route::get('/session',   [AuthController::class, 'session']);

// Password reset
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->middleware('throttle:5,1');
Route::post('/reset-password',  [AuthController::class, 'resetPassword'])->middleware('throttle:5,1');

// Public tournament & rankings data
Route::get('/tournaments', [TournamentController::class, 'apiIndex']);
Route::get('/rankings',    [RankingController::class, 'apiIndex']);

// Protected player endpoints
Route::middleware('auth')->group(function () {
    Route::get('/profile',         [ProfileController::class, 'show']);
    Route::post('/update-profile', [ProfileController::class, 'update']);
    Route::post('/cancel-booking', [ProfileController::class, 'cancelBooking']);

    Route::post('/tournaments/register', [TournamentController::class, 'apiRegister']);
});

// Admin-only endpoints
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard',            [AdminController::class, 'dashboard']);
    Route::get('/players',              [AdminController::class, 'players']);
    Route::post('/tournaments',         [AdminController::class, 'createTournament']);
    Route::post('/tournaments/update',  [AdminController::class, 'updateTournament']);
    Route::post('/tournaments/delete',  [AdminController::class, 'deleteTournament']);
    Route::post('/adjust-ranking',      [AdminController::class, 'adjustRanking']);
});

