<?php

namespace App\Http\Controllers;

use App\Models\User;


class RankingController extends Controller
{
    public function index() // Renamed from showPage
{
    $womenPlayers = User::where('role', 'player')
        ->where('gender', 'female')
        ->orderByDesc('points')
        ->get();

    $menPlayers = User::where('role', 'player')
        ->where('gender', 'male')
        ->orderByDesc('points')
        ->get();

    return view('rankings', compact('womenPlayers', 'menPlayers'));
}
}
