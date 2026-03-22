<?php

use App\Http\Controllers\RankingController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TournamentController;
use Illuminate\Support\Facades\Auth;
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

// 5. Authentication (Fixes the Login/Register/Logout errors)
Route::get('/login', function () {
    return view('auth.login'); 
})->name('login');

Route::get('/register', function () {
    return redirect('/login'); 
})->name('register');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// 6. Protected Player Routes
Route::middleware('auth')->group(function () {
    Route::post('/tournaments/{tournament}/register', [RegistrationController::class, 'store'])
        ->name('tournaments.register'); 
        
    Route::get('/profile', function () {
        return view('user.profile');
    })->name('profile');
});