@extends('layouts.app')

@section('title', 'Weekly Tournament — PADEL ACE')

@section('content')
<main class="weekly-main-wrapper">
    <div class="weekly-header-box">
        <h1 class="weekly-title">WEEKLY <span style="color: var(--neon-yellow);">Tournaments</span></h1>
    </div>

    <div class="weekly-layout-container">
        <aside class="weekly-sidebar">
            <h3 class="sidebar-title">Filters</h3>
            <div class="filter-group">
                <label class="section-label">Division</label>
                <div class="filter-radios">
                    <label class="radio-label"><input type="radio" name="lvl" value="" checked> All Levels</label>
                    <label class="radio-label"><input type="radio" name="lvl" value="C"> Intermediate</label>
                    <label class="radio-label"><input type="radio" name="lvl" value="B"> Advanced</label>
                </div>
            </div>
        </aside>

        <section class="weekly-content">
            <div class="weekly-grid">
                @forelse($tournaments as $tournament)
                    <div class="weekly-card" data-level="{{ $tournament->division == 'Advanced' ? 'B' : 'C' }}">
                        <div class="card-tag">WEEKLY</div>
                        <div class="card-main-info">
                            <div class="card-text">
                                <span class="card-division">{{ strtolower($tournament->division) }}</span>
                                <h3>{{ $tournament->title }}</h3>
                                <p class="card-date">
                                    {{ $tournament->event_date ? \Carbon\Carbon::parse($tournament->event_date)->format('l, M d • h:i A') : 'TBD' }}
                                </p>
                            </div>
                            
                            <div class="card-stats">
                                <div class="c-stat">
                                    <span>Entry Fee</span>
                                    <strong>€{{ number_format($tournament->entry_fee ?? 15.50, 2) }}</strong>
                                </div>
                                <div class="c-stat">
                                    <span>Teams</span>
                                    <strong>{{ $tournament->registrations_count ?? 0 }}/{{ $tournament->max_players ?? 16 }}</strong>
                                </div>
                                <div class="c-stat">
                                    <span>Points</span>
                                    <strong>{{ $tournament->win_points }}P</strong>
                                </div>
                            </div>

                            @auth
                                <button class="btn btn-primary btn-slim reg-btn" 
                                        data-id="{{ $tournament->id }}" 
                                        data-price="{{ $tournament->entry_fee ?? 15.50 }}"
                                        data-title="{{ $tournament->title }}">
                                    Register
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary btn-slim">Log In to Join</a>
                            @endauth
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1/-1; text-align: center; padding: 3rem;">
                        <p style="color: #706f6c;">No weekly tournaments available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</main>

<div id="checkout-modal" class="modal">
    <div class="modal-content">
        <button class="modal-close" aria-label="Close">&times;</button>
        <h2>Checkout</h2>
        <div class="checkout-summary-box">
            <p id="checkout-desc">Tournament Registration</p>
            <p id="checkout-amount">€15.50</p>
        </div>
        <form id="checkout-form">
            <input type="text" placeholder="Full Name" required>
            <input type="email" placeholder="Email" required>
            <hr style="margin: 1.5rem 0; opacity: 0.1;">
            <input type="text" placeholder="Card Number" required>
            <div style="display: flex; gap: 1rem;">
                <input type="text" placeholder="MM/YY" required style="flex:1;">
                <input type="text" placeholder="CVV" required style="flex:1;">
            </div>
            <button type="submit" class="btn btn-primary btn-block" style="margin-top: 1.5rem;">Pay Now</button>
        </form>
    </div>
</div>

<div id="confirmation-modal" class="modal">
    <div class="modal-content" style="text-align: center;">
        <div style="font-size: 3rem; margin-bottom: 1rem;">✓</div>
        <h2>Registration Confirmed!</h2>
        <p>Your spot is reserved. See you on the court!</p>
        <button class="btn btn-primary" id="btn-close-confirmation" style="margin-top: 1.5rem;">Done</button>
    </div>
</div>
@endsection