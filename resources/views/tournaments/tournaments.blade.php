@extends('layouts.app')

@section('title', 'Tournaments — PADEL ACE')
@section('body-class', 'tournament-hub')

@section('content')
<div class="page-layout-wrapper">
    <div class="tournament-hero">
        <h1 class="section-title">PADEL ACE CIRCUIT</h1>
        <p class="hero-subtitle">Official Deutschland Padel Tour (DPT) — Monthly Events</p>
    </div>

    <div class="sidebar-main-layout">
        <aside class="layout-sidebar">
            <h3 class="sidebar-title">Circuit Filters</h3>
            <div class="filter-section">
                <label class="section-label">Division</label>
                <div class="radio-grid">
                    <label class="custom-radio"><input type="radio" name="level" value="all" checked><span>All</span></label>
                    <label class="custom-radio"><input type="radio" name="level" value="A"><span>Professional</span></label>
                    <label class="custom-radio"><input type="radio" name="level" value="B"><span>Advanced</span></label>
                    <label class="custom-radio"><input type="radio" name="level" value="C"><span>Intermediate</span></label>
                    <label class="custom-radio"><input type="radio" name="level" value="D"><span>Beginner</span></label>
                    <label class="custom-radio"><input type="radio" name="level" value="Women"><span>Women</span></label>
                </div>
            </div>
            <input type="radio" name="tour" value="Monthly" checked style="display:none;">
        </aside>

        <section class="layout-main-content">
            <div id="tournament-grid" class="tournaments-grid">
                @foreach($tournaments as $tournament)
                    @php
                        $cardClass = match(strtolower($tournament->category)) {
                            'gold tour'   => 'gold',
                            'silver tour' => 'silver',
                            'dpt finale'  => 'finale',
                            default       => 'gold',
                        };
                        $dataLevel = match(strtolower($tournament->division)) {
                            'professional' => 'A',
                            'advanced'     => 'B',
                            'intermediate' => 'C',
                            'beginner'     => 'D',
                            'women'        => 'Women',
                            default        => 'all',
                        };
                    @endphp
                    <div class="t-card {{ $cardClass }}" data-level="{{ $dataLevel }}" data-tour="Monthly">
                        <div class="t-badge">{{ strtoupper($tournament->category ?? 'DPT') }}</div>
                        <div class="t-content">
                            <span class="t-division">DPT — {{ $tournament->division }}</span>
                            <h3>{{ $tournament->title }}</h3>
                            <div class="t-stats">
                                <div class="stat"><span>Required</span><strong>{{ $tournament->required_points }}P</strong></div>
                                <div class="stat"><span>Win</span><strong>{{ $tournament->win_points }}P</strong></div>
                            </div>
                            <div class="point-breakdown">
                                <span>
                                    @if($tournament->final_points) Final: {{ $tournament->final_points }}P | @endif
                                    @if($tournament->semi_points) Semi: {{ $tournament->semi_points }}P @endif
                                    @if($tournament->quarter_points) | QF: {{ $tournament->quarter_points }}P @endif
                                </span>
                            </div>
                            @auth
                                <form method="POST" action="{{ route('tournaments.register') }}">
                                    @csrf
                                    <input type="hidden" name="tournament_id" value="{{ $tournament->id }}">
                                    <button type="submit" class="btn btn-primary btn-block reg-btn"
                                            data-req="{{ $tournament->required_points }}">
                                        Register Team
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary btn-block">Log In to Register</a>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</div>

{{-- Status Modal --}}
<div id="status-modal" class="modal">
    <div class="modal-content">
        <button class="modal-close">&times;</button>
        <h2 id="modal-title">Status</h2>
        <p id="modal-msg"></p>
    </div>
</div>
@endsection