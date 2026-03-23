<?php

namespace App\Http\Controllers;

use App\Models\TournamentRegistration;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user()->loadCount('registrations');

        $upcomingTournaments = TournamentRegistration::with('tournament')
            ->where('user_id', $user->id)
            ->whereHas('tournament', fn ($q) => $q->where('event_date', '>=', now()))
            ->get();

        $divisions = [
            'Beginner'     => ['next' => 'Intermediate', 'points' => 100],
            'Intermediate' => ['next' => 'Advanced',     'points' => 300],
            'Advanced'     => ['next' => 'Professional', 'points' => 600],
            'Professional' => ['next' => null,           'points' => null],
        ];

        $nextDivision = $divisions[$user->division]['next'] ?? null;
        $nextPoints   = isset($divisions[$user->division]['points'])
            ? max(0, $divisions[$user->division]['points'] - $user->points)
            : null;

        return view('profile', compact('user', 'upcomingTournaments', 'nextDivision', 'nextPoints'));
    }
}
