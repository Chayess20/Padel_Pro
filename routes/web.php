<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TournamentController;
use Illuminate\Support\Facades\Route;

// 1. Home
Route::get('/', function () {
    return view('welcome'); 
});

// 2. Tournament Hubs (Matches your Navbar's route('tournaments.index'))
Route::get('/tournaments', [TournamentController::class, 'index'])
    ->name('tournaments.index'); 

// 3. Weekly (Matches your Navbar's route('tournaments.weekly'))
Route::get('/weekly-tournaments', [TournamentController::class, 'weekly'])
    ->name('tournaments.weekly'); 

// 4. Rankings (Matches your Navbar's route('rankings.index'))
Route::get('/rankings', [RankingController::class, 'index'])
    ->name('rankings.index');

// 5. Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post')
    ->middleware('throttle:5,1');

Route::get('/register', function () {
    return redirect('/login'); 
})->name('register');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 6. Protected Player Routes
Route::middleware('auth')->group(function () {
    Route::post('/tournaments/{tournament}/register', [RegistrationController::class, 'store'])
        ->name('tournaments.register'); 
        
    Route::get('/profile', [ProfileController::class, 'show'])
        ->name('profile');
});

