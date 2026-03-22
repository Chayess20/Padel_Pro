<?php

namespace App\Http\Controllers;

use App\Models\Tournament;

class TournamentController extends Controller
{
    public function index()
    {
        $tournaments = Tournament::where('type', 'monthly')
            ->where('status', 'open')
            ->orderBy('event_date', 'asc')
            ->get();

        // folder = tournaments | file = tournaments.blade.php
        return view('tournaments.tournaments', compact('tournaments'));
    }

    public function weekly()
    {
        $tournaments = Tournament::where('type', 'weekly')
            ->where('status', 'open')
            ->orderBy('event_date', 'asc')
            ->get();

        // folder = tournaments | file = weekly_tournaments.blade.php
        return view('tournaments.weekly_tournaments', compact('tournaments'));
    }
}