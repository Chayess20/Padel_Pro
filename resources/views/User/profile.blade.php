@extends('layouts.app')

@section('title', 'My Profile — PADEL ACE')

@section('content')
<div style="padding-top:80px; min-height:100vh; background:var(--off-white);">
    <div style="max-width:1200px; margin:0 auto; padding:2rem 5%;">

        <div class="profile-grid">
            {{-- Left column: player card --}}
            <div>
                <div class="player-card-main">
                    <div class="player-avatar" id="profile-avatar">??</div>
                    <h2 class="player-name" style="font-family:var(--font-heading); font-size:1.4rem; margin-bottom:0.25rem;">Loading…</h2>
                    <p id="profile-email" style="font-size:0.85rem; opacity:0.7;"></p>
                    <div class="division-badge">
                        <span id="current-division">—</span>
                    </div>
                </div>

                <div style="margin-top:1rem;">
                    <button id="edit-profile-btn" class="btn btn-outline" style="width:100%; margin-bottom:0.75rem;">Edit Profile</button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn" style="width:100%; background:transparent; border:1px solid #CBD5E0; color:var(--text-gray);">Log Out</button>
                    </form>
                </div>
            </div>

            {{-- Right column: stats + activity --}}
            <div>
                <div class="stats-overview-grid">
                    <div class="stat-box">
                        <strong id="player-points">0P</strong>
                        <span style="font-size:0.8rem; color:var(--text-gray);">Total Points</span>
                    </div>
                    <div class="stat-box">
                        <strong id="tournament-count">0</strong>
                        <span style="font-size:0.8rem; color:var(--text-gray);">Tournaments</span>
                    </div>
                    <div class="stat-box">
                        <strong id="division-display">—</strong>
                        <span style="font-size:0.8rem; color:var(--text-gray);">Division</span>
                    </div>
                </div>

                <div style="background:var(--white); border-radius:12px; padding:1.5rem; margin-bottom:1.5rem; box-shadow:0 4px 6px rgba(0,0,0,0.05);">
                    <div class="progression-header">
                        <h3 style="font-family:var(--font-heading); margin-bottom:0.5rem;">Division Progress</h3>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill" style="width:0%;"></div>
                    </div>
                    <p id="progress-req" style="font-size:0.8rem; color:var(--text-gray);"></p>
                    <p class="progression-hint" style="font-size:0.8rem; color:var(--text-gray); margin-top:0.5rem;"></p>
                </div>

                <div style="background:var(--white); border-radius:12px; padding:1.5rem; margin-bottom:1.5rem; box-shadow:0 4px 6px rgba(0,0,0,0.05);">
                    <h3 style="font-family:var(--font-heading); margin-bottom:1rem;">Upcoming Bookings</h3>
                    <div id="upcoming-bookings-list">
                        <p style="color:var(--text-gray); font-style:italic;">No upcoming bookings.</p>
                    </div>
                </div>

                <div style="background:var(--white); border-radius:12px; padding:1.5rem; box-shadow:0 4px 6px rgba(0,0,0,0.05);">
                    <h3 style="font-family:var(--font-heading); margin-bottom:1rem;">Recent Activity</h3>
                    <div id="recent-activity-list">
                        <p style="color:var(--text-gray); font-style:italic;">No tournament history yet.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Edit Profile Modal --}}
<div id="edit-profile-modal" class="modal">
    <div class="modal-content">
        <button class="modal-close" aria-label="Close">&times;</button>
        <h3 style="font-family:var(--font-heading); font-size:1.3rem; margin-bottom:1.5rem;">Edit Profile</h3>
        <p id="edit-profile-msg" style="display:none; margin-bottom:1rem; font-weight:500;"></p>
        <form id="edit-profile-form">
            @csrf
            <div class="input-group" style="margin-bottom:1rem;">
                <label>Phone Number</label>
                <input id="edit-phone" type="tel" name="phone" placeholder="+49 123 456 789">
            </div>
            <div class="input-group" style="margin-bottom:1rem;">
                <label>Current Password</label>
                <input type="password" name="current_password" placeholder="Leave blank to keep current">
            </div>
            <div class="input-group" style="margin-bottom:1.5rem;">
                <label>New Password</label>
                <input type="password" name="new_password" placeholder="Min. 8 characters">
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">Save Changes</button>
        </form>
    </div>
</div>
@endsection
