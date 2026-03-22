<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class RankingController extends Controller
{
    public function index()
    {
        $womenPlayers = User::where('role', 'player')
            ->where('gender', 'female')
            ->orderByDesc('points')
            ->get();

        $menPlayers = User::where('role', 'player')
            ->where('gender', 'male')
            ->orderByDesc('points')
            ->get();

        return view('rankings.rankings', compact('womenPlayers', 'menPlayers'));
    }

    /**
     * API: return ranked player list, optionally filtered by gender.
     */
    public function apiIndex(Request $request): JsonResponse
    {
        $query = User::where('role', 'player')
            ->orderByDesc('points');

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        $players = $query->get()->values()->map(function ($p, $index) {
            return [
                'rank'      => $index + 1,
                'full_name' => $p->name,
                'division'  => $p->division,
                'points'    => $p->points,
            ];
        });

        return response()->json(['success' => true, 'data' => $players]);
    }
}

