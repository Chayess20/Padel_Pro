@extends('layouts.app')

@section('title', 'Rankings — PADEL ACE')

@section('content')
<div class="page-layout-wrapper">
    <section class="section">
        <h1 class="section-title">Official Ranking System</h1>

        <div class="ranking-nav-container">
            <div class="toggle-pill">
                <button class="rank-tab-btn active" data-target="mixed-levels">Points System</button>
                <button class="rank-tab-btn" data-target="men-division">Men Division</button>
                <button class="rank-tab-btn" data-target="women-division">Women Division</button>
            </div>
        </div>

        {{-- Mixed Levels Table --}}
        <div id="mixed-levels" class="rank-tab-content active">
            <div class="ranking-table-container">
                <table class="ranking-table">
                    <thead>
                        <tr>
                            <th>Division</th><th>Min. Points</th><th>Win</th>
                            <th>Final</th><th>Semi-Final</th><th>Quarter-Final</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td><strong>Professional</strong></td><td>3000P</td><td>2000P</td><td>-</td><td>1000P</td><td>600P</td></tr>
                        <tr><td><strong>Advanced</strong></td><td>1000P</td><td>1000P</td><td>750P</td><td>500P</td><td>300P</td></tr>
                        <tr><td><strong>Intermediate</strong></td><td>300P</td><td>500P</td><td>300P</td><td>200P</td><td>100P</td></tr>
                        <tr><td><strong>Beginner</strong></td><td>0P</td><td>300P</td><td>200P</td><td>100P</td><td>-</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Men Division (live from DB) --}}
        <div id="men-division" class="rank-tab-content">
            <div class="ranking-table-container">
                <table class="ranking-table">
                    <thead>
                        <tr>
                            <th>Rank</th><th>Player Name</th><th>Division</th>
                            <th>Total Points</th><th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($menPlayers as $index => $player)
                        <tr>
                            <td>#{{ $index + 1 }}</td>
                            <td>{{ $player->name }}</td>
                            <td>{{ $player->division }}</td>
                            <td>{{ $player->points }}P</td>
                            <td>{{ $player->points >= 1000 ? 'Pro Active' : 'Active' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" style="text-align:center; color:#999; padding:2rem;">No players found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Women Division (live from DB) --}}
        <div id="women-division" class="rank-tab-content">
            <div class="ranking-table-container">
                <table class="ranking-table">
                    <thead>
                        <tr>
                            <th>Rank</th><th>Player Name</th><th>Division</th>
                            <th>Total Points</th><th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($womenPlayers as $index => $player)
                        <tr>
                            <td>#{{ $index + 1 }}</td>
                            <td>{{ $player->name }}</td>
                            <td>{{ $player->division }}</td>
                            <td>{{ $player->points }}P</td>
                            <td>{{ $player->points >= 1000 ? 'Pro Active' : 'Active' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" style="text-align:center; color:#999; padding:2rem;">No players found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rules-grid">
            <div class="rule-card">
                <h3>The Winner Rule</h3>
                <p>If you won Level A or B in the previous season, you cannot enter Level D the following season.</p>
            </div>
            <div class="rule-card">
                <h3>National Rank Entry</h3>
                <p>National ranked players can join their appropriate level directly for their first entry.</p>
            </div>
        </div>
    </section>
</div>
@endsection