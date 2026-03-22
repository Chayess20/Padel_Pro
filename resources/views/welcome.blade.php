@extends('layouts.app')

@section('title', 'PADEL ACE — Join Tournaments & Track Rankings')

@section('content')
<section id="home" class="hero">
    <div class="hero-content">
        <p class="hero-tag">Tournaments & Rankings</p>
        <h1>Smash your <em>best game</em> on the padel court</h1>
        <p class="hero-desc">Compete in our Weekly and Monthly tournament series to claim your spot on the official rankings.</p>
        <div class="hero-cta">
            <a href="{{ route('register') }}" class="btn btn-primary">Join us</a>
            <a href="{{ route('tournaments.index') }}" class="btn btn-outline">View Tournaments</a>
        </div>
    </div>
</section>

<section class="section features">
    <h2 class="section-title">Everything in One Place</h2>
    <div class="features-grid">
        <a href="{{ route('tournaments.index') }}" class="feature-card">
            <div class="feature-img">
                <img src="{{ asset('images/book-online.png') }}" alt="Padel player in action">
            </div>
            <h3>DPT</h3>
            <p>Deutschland Padel Tour — Monthly Tournament</p>
        </a>
        <a href="{{ route('tournaments.weekly') }}" class="feature-card">
            <div class="feature-img">
                <img src="{{ asset('images/find-players.png') }}" alt="Padel players together">
            </div>
            <h3>Weekly Tournament</h3>
            <p>Compete in weekly Tournament</p>
        </a>
        <a href="{{ route('tournaments.index') }}" class="feature-card">
            <div class="feature-img">
                <img src="{{ asset('images/tournaments.png') }}" alt="Padel tournament handshake">
            </div>
            <h3>Tournaments</h3>
            <p>Compete in weekly and monthly tournaments. Rankings, prizes, and glory await.</p>
        </a>
    </div>
</section>
@endsection