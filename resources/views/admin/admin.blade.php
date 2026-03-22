@extends('layouts.app')

@section('title', 'Admin Dashboard — PADEL ACE')

@section('content')
<div class="admin-page admin-dashboard">
    <div style="display:flex; min-height:calc(100vh - 80px);">

        {{-- Sidebar --}}
        <aside style="width:220px; background:var(--navy); padding:2rem 1rem; flex-shrink:0;">
            <p style="color:var(--neon-yellow); font-family:var(--font-heading); font-size:0.75rem; letter-spacing:0.1em; margin-bottom:1rem;">ADMIN PANEL</p>
            <nav>
                <a href="#overview"     class="admin-link active">Overview</a>
                <a href="#players"      class="admin-link">Players</a>
                <a href="#tournaments"  class="admin-link">Tournaments</a>
                <a href="#rankings"     class="admin-link">Rankings</a>
            </nav>
            <div style="margin-top:auto; padding-top:2rem;">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button id="admin-logout-btn" type="submit"
                        style="background:none; border:1px solid rgba(255,255,255,0.2); color:rgba(255,255,255,0.6);
                               width:100%; padding:0.6rem; border-radius:6px; cursor:pointer; font-family:var(--font-body);">
                        Log Out
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <main style="flex:1; padding:2rem; overflow-y:auto;">

            {{-- ===================== OVERVIEW ===================== --}}
            <div id="overview" class="admin-view active">
                <h2 style="font-family:var(--font-heading); font-size:1.6rem; margin-bottom:1.5rem;">Dashboard Overview</h2>

                <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; margin-bottom:2rem;">
                    <div style="background:var(--white); border-radius:12px; padding:1.5rem; box-shadow:0 2px 8px rgba(0,0,0,0.06);">
                        <p style="font-size:0.8rem; color:var(--text-gray); margin-bottom:0.25rem;">Total Players</p>
                        <p class="stat-value" style="font-family:var(--font-heading); font-size:2rem; color:var(--navy);">—</p>
                        <p class="stat-trend" style="font-size:0.8rem; color:var(--text-gray);">Registered accounts</p>
                    </div>
                    <div style="background:var(--white); border-radius:12px; padding:1.5rem; box-shadow:0 2px 8px rgba(0,0,0,0.06);">
                        <p style="font-size:0.8rem; color:var(--text-gray); margin-bottom:0.25rem;">Active Events</p>
                        <p class="stat-value" style="font-family:var(--font-heading); font-size:2rem; color:var(--navy);">—</p>
                        <p class="stat-trend" style="font-size:0.8rem; color:var(--text-gray);">Open &amp; live tournaments</p>
                    </div>
                    <div style="background:var(--white); border-radius:12px; padding:1.5rem; box-shadow:0 2px 8px rgba(0,0,0,0.06);">
                        <p style="font-size:0.8rem; color:var(--text-gray); margin-bottom:0.25rem;">Pending Scores</p>
                        <p class="stat-value" style="font-family:var(--font-heading); font-size:2rem; color:var(--navy);">—</p>
                        <p class="stat-trend" style="font-size:0.8rem; color:var(--text-gray);">Awaiting results entry</p>
                    </div>
                </div>

                <div style="background:var(--white); border-radius:12px; padding:1.5rem; box-shadow:0 2px 8px rgba(0,0,0,0.06);">
                    <h3 style="font-family:var(--font-heading); margin-bottom:1rem;">Tournament Overview</h3>
                    <div style="overflow-x:auto;">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Registrations</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td colspan="5" style="text-align:center; color:#999;">Loading…</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ===================== PLAYERS ===================== --}}
            <div id="players" class="admin-view">
                <h2 style="font-family:var(--font-heading); font-size:1.6rem; margin-bottom:1.5rem;">Players</h2>
                <input type="search" class="admin-search-bar" placeholder="Search by name or email…">
                <div style="background:var(--white); border-radius:12px; padding:1.5rem; box-shadow:0 2px 8px rgba(0,0,0,0.06);">
                    <div style="overflow-x:auto;">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Division</th>
                                    <th>Points</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td colspan="5" style="text-align:center; color:#999;">Loading…</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ===================== MANAGE TOURNAMENTS ===================== --}}
            <div id="tournaments" class="admin-view">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
                    <h2 style="font-family:var(--font-heading); font-size:1.6rem;">Manage Tournaments</h2>
                    <button class="btn btn-primary" style="padding:0.6rem 1.4rem; font-size:0.9rem;"
                            onclick="document.getElementById('event-modal').classList.add('active')">
                        + New Tournament
                    </button>
                </div>
                <div style="background:var(--white); border-radius:12px; padding:1.5rem; box-shadow:0 2px 8px rgba(0,0,0,0.06);">
                    <div style="overflow-x:auto;">
                        <table class="admin-table" id="manage-tournaments-table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Division</th>
                                    <th>Registrations</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td colspan="7" style="text-align:center; color:#999;">Loading…</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ===================== RANKINGS ===================== --}}
            <div id="rankings" class="admin-view">
                <h2 style="font-family:var(--font-heading); font-size:1.6rem; margin-bottom:1.5rem;">Adjust Rankings</h2>
                <div style="background:var(--white); border-radius:12px; padding:1.5rem; box-shadow:0 2px 8px rgba(0,0,0,0.06); max-width:600px;">
                    <form class="score-entry-form admin-form">
                        @csrf
                        <label style="display:block; font-weight:600; margin-bottom:0.5rem;">Player ID</label>
                        <input type="number" name="player_id" placeholder="Enter player ID" required>

                        <label style="display:block; font-weight:600; margin-bottom:0.5rem;">Points</label>
                        <input type="number" name="points" placeholder="Number of points" min="1" required>

                        <label style="display:block; font-weight:600; margin-bottom:0.75rem;">Adjustment Type</label>
                        <div style="display:flex; gap:2rem; margin-bottom:1rem;">
                            <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer;">
                                <input type="radio" name="adj" value="addition" checked> Add Points
                            </label>
                            <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer;">
                                <input type="radio" name="adj" value="deduction"> Deduct Points
                            </label>
                        </div>

                        <label style="display:block; font-weight:600; margin-bottom:0.5rem;">Reason <span style="font-weight:400; color:var(--text-gray);">(optional)</span></label>
                        <input type="text" name="reason" placeholder="e.g. Tournament win, Manual correction">

                        <button type="submit" class="btn btn-primary" style="width:100%; margin-top:0.5rem;">Apply Adjustment</button>
                    </form>
                </div>
            </div>

        </main>
    </div>
</div>

{{-- ===================== CREATE TOURNAMENT MODAL ===================== --}}
<div id="event-modal" class="modal">
    <div class="modal-content" style="max-width:500px;">
        <button class="modal-close" aria-label="Close">&times;</button>
        <h3 style="font-family:var(--font-heading); font-size:1.3rem; margin-bottom:1.5rem;">New Tournament</h3>
        <form class="admin-form">
            @csrf
            <input type="text"   name="title"       placeholder="Tournament Title"  required>
            <select name="type">
                <option value="monthly">Monthly (DPT)</option>
                <option value="weekly">Weekly</option>
            </select>
            <input type="text"   name="category"    placeholder="Category (e.g. Gold Tour)">
            <input type="text"   name="division"    placeholder="Division (e.g. Advanced)" required>
            <input type="date"   name="event_date"  placeholder="Event Date">
            <input type="number" name="entry_fee"   placeholder="Entry Fee (€)" step="0.01" min="0">
            <input type="number" name="max_players" placeholder="Max Players" min="1">
            <input type="number" name="win_points"  placeholder="Win Points" min="0">
            <button type="submit" class="btn btn-primary" style="width:100%;">Create Tournament</button>
        </form>
    </div>
</div>

{{-- ===================== EDIT TOURNAMENT MODAL ===================== --}}
<div id="edit-tournament-modal" class="modal">
    <div class="modal-content" style="max-width:500px;">
        <button class="modal-close" aria-label="Close">&times;</button>
        <h3 style="font-family:var(--font-heading); font-size:1.3rem; margin-bottom:1.5rem;">Edit Tournament</h3>
        <form id="edit-tournament-form" class="admin-form">
            @csrf
            <input type="hidden" id="edit-t-id"    name="id">
            <input type="text"   id="edit-t-title"    name="title"       placeholder="Tournament Title" required>
            <select id="edit-t-type" name="type">
                <option value="monthly">Monthly (DPT)</option>
                <option value="weekly">Weekly</option>
            </select>
            <input type="text"   id="edit-t-category" name="category"    placeholder="Category">
            <input type="text"   id="edit-t-division" name="division"    placeholder="Division" required>
            <select id="edit-t-status" name="status">
                <option value="draft">Draft</option>
                <option value="open">Open</option>
                <option value="live">Live</option>
                <option value="completed">Completed</option>
            </select>
            <input type="date"   id="edit-t-date"     name="event_date">
            <input type="number" id="edit-t-fee"      name="entry_fee"   placeholder="Entry Fee (€)" step="0.01" min="0">
            <input type="number" id="edit-t-max"      name="max_players" placeholder="Max Players" min="1">
            <input type="number" id="edit-t-win"      name="win_points"  placeholder="Win Points" min="0">
            <button type="submit" class="btn btn-primary" style="width:100%;">Save Changes</button>
        </form>
    </div>
</div>

{{-- ===================== DELETE CONFIRM MODAL ===================== --}}
<div id="delete-tournament-modal" class="modal">
    <div class="modal-content" style="max-width:440px; text-align:center;">
        <button class="modal-close" aria-label="Close">&times;</button>
        <div style="font-size:2.5rem; margin-bottom:1rem;">⚠️</div>
        <h3 style="font-family:var(--font-heading); font-size:1.3rem; margin-bottom:1rem;">Delete Tournament</h3>
        <p id="delete-tournament-msg" style="color:var(--text-gray); margin-bottom:1.5rem;"></p>
        <div style="display:flex; gap:1rem; justify-content:center;">
            <button class="modal-close btn" style="border:1px solid #CBD5E0; background:transparent; color:var(--text-gray);">Cancel</button>
            <button id="confirm-delete-btn" class="btn btn-primary" style="background:#e63946;">Delete</button>
        </div>
    </div>
</div>

{{-- ===================== STATUS MODAL ===================== --}}
<div id="status-modal" class="modal">
    <div class="modal-content" style="max-width:400px; text-align:center;">
        <button class="modal-close" aria-label="Close">&times;</button>
        <h2 id="modal-title" style="font-family:var(--font-heading); margin-bottom:0.75rem;">Status</h2>
        <p id="modal-msg" style="color:var(--text-gray);"></p>
    </div>
</div>
@endsection
