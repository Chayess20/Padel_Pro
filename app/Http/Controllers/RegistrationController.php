<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\TournamentRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
   
    public function store(Request $request, Tournament $tournament)
    {

        $exists = TournamentRegistration::where('user_id', Auth::id())
            ->where('tournament_id', $tournament->id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false, 
                'message' => 'You are already registered for this tournament!'
            ], 422);
        }

        if ($tournament->registrations()->count() >= $tournament->max_players) {
            return response()->json([
                'success' => false, 
                'message' => 'Tournament is full!'
            ], 422);
        }

        TournamentRegistration::create([
            'user_id' => Auth::id(),
            'tournament_id' => $tournament->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registration successful!'
        ]);
    }
}