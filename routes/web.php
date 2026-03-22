<?php

use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\TournamentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// 1. Home
Route::get('/', function () {
    return view('welcome');
});

// 2. Tournament Hubs
Route::get('/tournaments', [TournamentController::class, 'index'])
    ->name('tournaments.index');

// 3. Weekly
Route::get('/weekly-tournaments', [TournamentController::class, 'weekly'])
    ->name('tournaments.weekly');

// 4. Rankings
Route::get('/rankings', [RankingController::class, 'index'])
    ->name('rankings.index');

// 5. Authentication
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// 6. Password Reset Pages
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::get('/reset-password', function () {
    return view('auth.reset-password');
})->name('password.reset');

// 7. Protected Player Routes
Route::middleware('auth')->group(function () {
    // Tournament registration from Blade form (tournament_id in POST body)
    Route::post('/tournaments/register', [RegistrationController::class, 'store'])
        ->name('tournaments.register');

    Route::get('/profile', function () {
        return view('User.profile');
    })->name('profile');
});

// 8. Admin page (requires admin role)
Route::get('/admin', function () {
    return view('admin.admin');
})->middleware(['auth', 'admin'])->name('admin.dashboard');

// 9. Legal pages
Route::get('/terms', function () {
    return view('legal.terms');
})->name('legal.terms');

Route::get('/privacy', function () {
    return view('legal.privacy');
})->name('legal.privacy');
