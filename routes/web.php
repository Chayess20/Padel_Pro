<?php

use App\Http\Controllers\RankingController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TournamentController;
use Illuminate\Http\Request;
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

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email'    => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended('/');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
})->middleware('guest');

Route::get('/register', function () {
    return redirect('/login'); 
})->name('register');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// 6. Legal Pages
Route::view('/terms',   'legal.terms')->name('legal.terms');
Route::view('/privacy', 'legal.privacy')->name('legal.privacy');
Route::get('/contact',  function () {
    return view('legal.contact');
})->name('legal.contact');

Route::post('/contact', function (Request $request) {
    $request->validate([
        'name'    => ['required', 'string', 'max:255'],
        'email'   => ['required', 'email', 'max:255'],
        'message' => ['required', 'string', 'max:5000'],
    ]);

    // TODO: send email via Mail facade once a mailer is configured
    return back()->with('success', 'Thank you! Your message has been received.');
})->name('legal.contact.submit');

// 7. Protected Player Routes
Route::middleware('auth')->group(function () {
    Route::post('/tournaments/{tournament}/register', [RegistrationController::class, 'store'])
        ->name('tournaments.register');

    Route::get('/profile', function () {
        /** @var \App\Models\User $user */
        $user = auth()->user()->loadCount(['registrations as tournament_registrations_count']);

        $upcomingTournaments = $user->registrations()
            ->with('tournament')
            ->whereHas('tournament', fn ($q) => $q->whereDate('event_date', '>=', now()))
            ->get();

        $divisions    = ['Beginner' => 0, 'Intermediate' => 300, 'Advanced' => 1000, 'Professional' => 3000];
        $names        = array_keys($divisions);
        $currentIndex = array_search($user->division, $names, true);
        $nextDivision = ($currentIndex !== false && $currentIndex < count($names) - 1)
            ? $names[$currentIndex + 1]
            : null;
        $nextPoints   = $nextDivision ? max(0, $divisions[$nextDivision] - $user->points) : null;

        return view('profile', [
            'user'                => $user,
            'upcomingTournaments' => $upcomingTournaments,
            'upcomingCourts'      => collect(),   // court-booking feature not yet implemented
            'nextDivision'        => $nextDivision,
            'nextPoints'          => $nextPoints,
        ]);
    })->name('profile');

    Route::post('/bookings/cancel', function () {
        // Placeholder — court & tournament booking cancellation will be implemented later.
        return back()->with('info', 'Cancellation is not yet available.');
    })->name('bookings.cancel');
});