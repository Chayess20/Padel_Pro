<?php

namespace App\Http\Controllers;

use App\Models\RankingAdjustment;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Dashboard overview: totals + recent tournaments.
     */
    public function dashboard(): JsonResponse
    {
        $totalPlayers  = User::where('role', 'player')->count();
        $activeEvents  = Tournament::whereIn('status', ['open', 'live'])->count();
        $pendingScores = Tournament::where('status', 'live')->count();
        $monthlyCount  = Tournament::where('type', 'monthly')->count();
        $weeklyCount   = Tournament::where('type', 'weekly')->count();

        $tournaments = Tournament::withCount('registrations')
            ->orderBy('event_date', 'asc')
            ->get()
            ->map(fn ($t) => [
                'id'               => $t->id,
                'title'            => $t->title,
                'type'             => $t->type,
                'category'         => $t->category,
                'division'         => $t->division,
                'status'           => $t->status,
                'event_date'       => $t->event_date,
                'max_players'      => $t->max_players,
                'registered_count' => $t->registrations_count,
                'win_points'       => $t->win_points,
                'entry_fee'        => $t->entry_fee,
                'final_points'     => $t->final_points,
                'semi_points'      => $t->semi_points,
                'quarter_points'   => $t->quarter_points,
                'required_points'  => $t->required_points,
            ]);

        return response()->json([
            'success' => true,
            'data'    => compact(
                'totalPlayers', 'activeEvents', 'pendingScores',
                'monthlyCount', 'weeklyCount', 'tournaments'
            ),
        ]);
    }

    /**
     * Paginated player list with optional search.
     */
    public function players(Request $request): JsonResponse
    {
        $query = User::where('role', 'player')->orderByDesc('points');

        if ($request->filled('search')) {
            $s = '%' . $request->search . '%';
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', $s)->orWhere('email', 'like', $s);
            });
        }

        $paginator = $query->paginate(20);

        $players = $paginator->getCollection()->map(fn ($p) => [
            'id'        => $p->id,
            'full_name' => $p->name,
            'email'     => $p->email,
            'division'  => $p->division,
            'points'    => $p->points,
        ]);

        return response()->json([
            'success' => true,
            'data'    => $players,
            'meta'    => [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
            ],
        ]);
    }

    /**
     * Create a new tournament.
     */
    public function createTournament(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title'          => ['required', 'string', 'max:255'],
            'type'           => ['required', 'in:monthly,weekly'],
            'category'       => ['nullable', 'string', 'max:100'],
            'division'       => ['required', 'string', 'max:100'],
            'event_date'     => ['nullable', 'date'],
            'entry_fee'      => ['nullable', 'numeric', 'min:0'],
            'max_players'    => ['nullable', 'integer', 'min:0'],
            'win_points'     => ['nullable', 'integer', 'min:0'],
            'required_points'=> ['nullable', 'integer', 'min:0'],
            'final_points'   => ['nullable', 'integer', 'min:0'],
            'semi_points'    => ['nullable', 'integer', 'min:0'],
            'quarter_points' => ['nullable', 'integer', 'min:0'],
        ]);

        $tournament = Tournament::create([
            'title'           => $validated['title'],
            'type'            => $validated['type'],
            'category'        => $validated['category'] ?? null,
            'division'        => $validated['division'],
            'event_date'      => $validated['event_date'] ?? null,
            'entry_fee'       => $validated['entry_fee'] ?? 0,
            'max_players'     => $validated['max_players'] ?? 16,
            'win_points'      => $validated['win_points'] ?? 0,
            'required_points' => $validated['required_points'] ?? 0,
            'final_points'    => $validated['final_points'] ?? 0,
            'semi_points'     => $validated['semi_points'] ?? 0,
            'quarter_points'  => $validated['quarter_points'] ?? 0,
            'status'          => 'open',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tournament created successfully.',
            'data'    => ['id' => $tournament->id],
        ]);
    }

    /**
     * Update an existing tournament.
     */
    public function updateTournament(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id'          => ['required', 'integer', 'exists:tournaments,id'],
            'title'       => ['required', 'string', 'max:255'],
            'type'        => ['required', 'in:monthly,weekly'],
            'category'    => ['nullable', 'string', 'max:100'],
            'division'    => ['required', 'string', 'max:100'],
            'status'      => ['nullable', 'in:draft,open,live,completed'],
            'event_date'  => ['nullable', 'date'],
            'entry_fee'   => ['nullable', 'numeric', 'min:0'],
            'max_players' => ['nullable', 'integer', 'min:0'],
            'win_points'  => ['nullable', 'integer', 'min:0'],
        ]);

        $tournament = Tournament::findOrFail($validated['id']);
        $tournament->update([
            'title'       => $validated['title'],
            'type'        => $validated['type'],
            'category'    => $validated['category'] ?? $tournament->category,
            'division'    => $validated['division'],
            'status'      => $validated['status'] ?? $tournament->status,
            'event_date'  => $validated['event_date'] ?? $tournament->event_date,
            'entry_fee'   => $validated['entry_fee'] ?? $tournament->entry_fee,
            'max_players' => $validated['max_players'] ?? $tournament->max_players,
            'win_points'  => $validated['win_points'] ?? $tournament->win_points,
        ]);

        return response()->json(['success' => true, 'message' => 'Tournament updated.']);
    }

    /**
     * Permanently delete a tournament.
     */
    public function deleteTournament(Request $request): JsonResponse
    {
        $request->validate(['id' => ['required', 'integer', 'exists:tournaments,id']]);

        Tournament::findOrFail($request->id)->delete();

        return response()->json(['success' => true, 'message' => 'Tournament deleted.']);
    }

    /**
     * Add or deduct points from a player and auto-update their division.
     */
    public function adjustRanking(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'points'  => ['required', 'integer', 'min:1'],
            'type'    => ['required', 'in:addition,deduction'],
            'reason'  => ['nullable', 'string', 'max:500'],
        ]);

        $user   = User::findOrFail($validated['user_id']);
        $before = $user->points;

        $user->points = $validated['type'] === 'addition'
            ? $user->points + $validated['points']
            : max(0, $user->points - $validated['points']);

        $user->division = User::divisionForPoints($user->points);
        $user->save();

        RankingAdjustment::create([
            'user_id'       => $user->id,
            'points_before' => $before,
            'amount'        => $validated['type'] === 'addition' ? $validated['points'] : -$validated['points'],
            'points_after'  => $user->points,
            'reason'        => $validated['reason'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => "{$user->name} now has {$user->points}P ({$user->division}).",
        ]);
    }

}

