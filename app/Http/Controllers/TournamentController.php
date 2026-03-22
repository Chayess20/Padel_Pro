<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\TournamentRegistration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TournamentController extends Controller
{
    public function index()
    {
        $tournaments = Tournament::withCount('registrations')
            ->where('type', 'monthly')
            ->where('status', 'open')
            ->orderBy('event_date', 'asc')
            ->get();

        return view('tournaments.tournaments', compact('tournaments'));
    }

    public function weekly()
    {
        $tournaments = Tournament::withCount('registrations')
            ->where('type', 'weekly')
            ->where('status', 'open')
            ->orderBy('event_date', 'asc')
            ->get();

        return view('tournaments.weekly_tournaments', compact('tournaments'));
    }

    /**
     * API: list tournaments with optional type/division filters.
     */
    public function apiIndex(Request $request): JsonResponse
    {
        $query = Tournament::withCount('registrations')
            ->where('status', 'open')
            ->orderBy('event_date', 'asc');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('division') && $request->division !== 'all') {
            $query->where('division', $request->division);
        }

        $tournaments = $query->get()->map(function ($t) {
            return [
                'id'               => $t->id,
                'title'            => $t->title,
                'type'             => $t->type,
                'category'         => $t->category,
                'division'         => $t->division,
                'required_points'  => $t->required_points,
                'win_points'       => $t->win_points,
                'final_points'     => $t->final_points,
                'semi_points'      => $t->semi_points,
                'quarter_points'   => $t->quarter_points,
                'entry_fee'        => $t->entry_fee,
                'max_players'      => $t->max_players,
                'registered_count' => $t->registrations_count,
                'event_date'       => $t->event_date,
                'status'           => $t->status,
            ];
        });

        return response()->json(['success' => true, 'data' => $tournaments]);
    }

    /**
     * API: register the authenticated user for a tournament.
     */
    public function apiRegister(Request $request): JsonResponse
    {
        if (! Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Please log in to register.'], 401);
        }

        $request->validate(['tournament_id' => ['required', 'integer', 'exists:tournaments,id']]);

        $tournament = Tournament::findOrFail($request->tournament_id);

        if ($tournament->status !== 'open') {
            return response()->json(['success' => false, 'message' => 'This tournament is not open for registration.'], 422);
        }

        $exists = TournamentRegistration::where('user_id', Auth::id())
            ->where('tournament_id', $tournament->id)
            ->exists();

        if ($exists) {
            return response()->json(['success' => false, 'message' => 'You are already registered for this tournament!'], 422);
        }

        if ($tournament->registrations()->count() >= $tournament->max_players) {
            return response()->json(['success' => false, 'message' => 'Tournament is full!'], 422);
        }

        TournamentRegistration::create([
            'user_id'       => Auth::id(),
            'tournament_id' => $tournament->id,
        ]);

        return response()->json(['success' => true, 'message' => 'Registration successful!']);
    }
}
