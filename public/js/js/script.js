/**
 * PADEL ACE — Front-End JavaScript
 * Connects all forms and interactive elements to the PHP API.
 */

// -----------------------------------------------
// Utility helpers
// -----------------------------------------------

/** Base path to Laravel api routes */
const API = '/api';

/** CSRF token received from the server after login/register/session check */
let _csrfToken = '';

function setCsrfToken(token) {
    if (token) _csrfToken = token;
}

async function apiFetch(endpoint, options = {}) {
    const method = (options.method || 'GET').toUpperCase();
    const csrfHeader = (method !== 'GET' && method !== 'HEAD' && _csrfToken)
        ? { 'X-CSRF-Token': _csrfToken }
        : {};

    const res = await fetch(`${API}/${endpoint}`, {
        credentials: 'same-origin',
        ...options,
        headers: {
            'Content-Type': 'application/json',
            ...csrfHeader,
            ...(options.headers || {}),
        },
    });
    const json = await res.json().catch(() => ({ success: false, message: 'Server error.' }));
    return { ok: res.ok, status: res.status, ...json };
}

function openModal(id) {
    const m = document.getElementById(id);
    if (m) m.classList.add('active');
}

function closeModal(id) {
    const m = document.getElementById(id);
    if (m) m.classList.remove('active');
}

function escHtml(str) {
    const d = document.createElement('div');
    d.appendChild(document.createTextNode(str));
    return d.innerHTML;
}

// Close modals on backdrop click
document.addEventListener('click', (e) => {
    if (e.target.classList.contains('modal')) {
        e.target.classList.remove('active');
    }
});
document.querySelectorAll('.modal-close').forEach((btn) => {
    btn.addEventListener('click', () => {
        const modal = btn.closest('.modal');
        if (modal) modal.classList.remove('active');
    });
});

// -----------------------------------------------
// Navigation: show/hide Sign Up based on session
// -----------------------------------------------
async function updateNav() {
    try {
        const res = await apiFetch('session');
        const navSignUp = document.querySelectorAll('a[href="sign_up.html"], a[href="sign-up.html"]');
        const navLogin  = document.querySelectorAll('a[href="log_in.html"]');

        if (res.success && res.data) {
            const user = res.data;
            setCsrfToken(user.csrf_token);
            navSignUp.forEach((link) => {
                link.textContent = user.role === 'admin' ? 'Dashboard' : 'Profile';
                link.href = user.role === 'admin' ? 'admin.html' : 'profile.html';
                link.classList.add('btn-nav');
            });
            navLogin.forEach((link) => {
                link.textContent = 'Logout';
                link.href = '#';
                link.addEventListener('click', async (e) => {
                    e.preventDefault();
                    await apiFetch('logout', { method: 'POST' });
                    window.location.href = 'index.html';
                });
            });
        }
    } catch (_) {
        // Not critical – silently fail
    }
}

// -----------------------------------------------
// Sign Up Page
// -----------------------------------------------
const signupForm = document.getElementById('signup-form');
if (signupForm) {
    // Ensure message placeholder exists
    let msgEl = document.getElementById('signup-message');
    if (!msgEl) {
        msgEl = document.createElement('p');
        msgEl.id = 'signup-message';
        msgEl.style.cssText = 'display:none;margin-bottom:1rem;font-weight:500;';
        signupForm.insertBefore(msgEl, signupForm.firstChild);
    }

    signupForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        msgEl.style.display = 'none';

        const payload = {
            full_name:        signupForm.querySelector('[name="full_name"]')?.value.trim(),
            email:            signupForm.querySelector('[name="email"]')?.value.trim(),
            phone:            signupForm.querySelector('[name="phone"]')?.value.trim(),
            gender:           signupForm.querySelector('[name="gender"]')?.value,
            national_ranking: signupForm.querySelector('[name="national_ranking"]')?.value,
            password:         signupForm.querySelector('[name="password"]')?.value,
        };

        const res = await apiFetch('register', { method: 'POST', body: JSON.stringify(payload) });
        if (res.success) {
            setCsrfToken(res.data?.csrf_token);
            window.location.href = 'profile.html';
        } else {
            msgEl.textContent = res.message || 'Registration failed.';
            msgEl.style.color = '#e74c3c';
            msgEl.style.display = 'block';
        }
    });
}

// -----------------------------------------------
// Login Page
// -----------------------------------------------
const loginForm = document.getElementById('login-form');
if (loginForm) {
    let msgEl = document.getElementById('login-message');
    if (!msgEl) {
        msgEl = document.createElement('p');
        msgEl.id = 'login-message';
        msgEl.style.cssText = 'display:none;margin-bottom:1rem;font-weight:500;';
        loginForm.insertBefore(msgEl, loginForm.firstChild);
    }

    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        msgEl.style.display = 'none';

        const payload = {
            email:    loginForm.querySelector('[name="email"]')?.value.trim(),
            password: loginForm.querySelector('[name="password"]')?.value,
        };

        const res = await apiFetch('login', { method: 'POST', body: JSON.stringify(payload) });
        if (res.success) {
            setCsrfToken(res.data?.csrf_token);
            window.location.href = res.data?.role === 'admin' ? 'admin.html' : 'profile.html';
        } else {
            msgEl.textContent = res.message || 'Login failed.';
            msgEl.style.color = '#e74c3c';
            msgEl.style.display = 'block';
        }
    });
}

// -----------------------------------------------
// Profile Page
// -----------------------------------------------
if (document.querySelector('.profile-grid')) {
    (async () => {
        // First check session — redirect admin to their dashboard
        const sessionRes = await apiFetch('session');
        if (!sessionRes.success || !sessionRes.data) {
            window.location.href = 'log_in.html';
            return;
        }
        setCsrfToken(sessionRes.data.csrf_token);
        if (sessionRes.data.role === 'admin') {
            window.location.href = 'admin.html';
            return;
        }

        const res = await apiFetch('profile');
        if (!res.success) {
            window.location.href = 'log_in.html';
            return;
        }
        const d = res.data;

        // Name / email / avatar initials / division / points
        const nameEl = document.querySelector('.player-name');
        if (nameEl) nameEl.textContent = d.full_name;

        const emailEl = document.getElementById('profile-email');
        if (emailEl) emailEl.textContent = d.email;

        const avatarEl = document.getElementById('profile-avatar');
        if (avatarEl) {
            const initials = d.full_name.split(' ').map((w) => w[0]).join('').slice(0, 2).toUpperCase();
            avatarEl.textContent = initials;
        }

        const divEl = document.getElementById('current-division');
        if (divEl) divEl.textContent = d.division.toUpperCase();

        const divDisplay = document.getElementById('division-display');
        if (divDisplay) divDisplay.textContent = d.division;

        const pointsEl = document.getElementById('player-points');
        if (pointsEl) pointsEl.textContent = d.points + 'P';

        const tcEl = document.getElementById('tournament-count');
        if (tcEl) tcEl.textContent = d.tournament_count;

        // Progress bar
        if (d.next_points) {
            const pct = Math.min(100, Math.round((d.points / d.next_points) * 100));
            const barFill = document.querySelector('.progress-bar-fill');
            if (barFill) barFill.style.width = pct + '%';
            const progHeader = document.querySelector('.progression-header h3');
            if (progHeader) progHeader.textContent = 'Progress to ' + d.next_division;
            const progReq = document.getElementById('progress-req');
            if (progReq) progReq.textContent = d.next_points + 'P Required';
            const progHint = document.querySelector('.progression-hint');
            if (progHint) {
                const needed = d.next_points - d.points;
                progHint.textContent = 'Earn ' + needed + ' more points to unlock ' + d.next_division + ' Tournaments.';
            }
        }

        // Recent activity
        const activityList = document.getElementById('recent-activity-list');
        if (activityList && d.recent_tournaments.length > 0) {
            activityList.innerHTML = d.recent_tournaments.map((t) => `
                <div class="history-item">
                    <div class="history-info">
                        <strong>${escHtml(t.title)}</strong>
                        <span>${escHtml(t.category || '')} • ${escHtml(t.division)}</span>
                    </div>
                </div>`).join('');
        }

        // Upcoming bookings
        renderUpcomingBookings(d.upcoming_tournaments || []);

        // Pre-fill phone in the edit modal
        const editPhoneInput = document.getElementById('edit-phone');
        if (editPhoneInput && d.phone) editPhoneInput.value = d.phone;
    })();

    // -----------------------------------------------
    // Edit Profile Modal
    // -----------------------------------------------
    const editProfileBtn  = document.getElementById('edit-profile-btn');
    const editProfileForm = document.getElementById('edit-profile-form');
    const editProfileMsg  = document.getElementById('edit-profile-msg');

    if (editProfileBtn) {
        editProfileBtn.addEventListener('click', () => openModal('edit-profile-modal'));
    }

    if (editProfileForm) {
        editProfileForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            if (editProfileMsg) editProfileMsg.style.display = 'none';

            const payload = {
                phone:            editProfileForm.querySelector('[name="phone"]')?.value.trim(),
                current_password: editProfileForm.querySelector('[name="current_password"]')?.value,
                new_password:     editProfileForm.querySelector('[name="new_password"]')?.value,
            };

            const res = await apiFetch('update-profile', {
                method: 'POST',
                body: JSON.stringify(payload),
            });

            if (editProfileMsg) {
                editProfileMsg.textContent   = res.message || (res.success ? 'Saved!' : 'Error.');
                editProfileMsg.style.color   = res.success ? '#2ecc71' : '#e74c3c';
                editProfileMsg.style.display = 'block';
            }

            if (res.success) {
                // Clear password fields; keep phone
                editProfileForm.querySelector('[name="current_password"]').value = '';
                editProfileForm.querySelector('[name="new_password"]').value     = '';
                setTimeout(() => closeModal('edit-profile-modal'), 1500);
            }
        });
    }

    // -----------------------------------------------
    // Upcoming Bookings — render + cancel
    // -----------------------------------------------
    function renderUpcomingBookings(tournaments) {
        const container = document.getElementById('upcoming-bookings-list');
        if (!container) return;

        if (tournaments.length === 0) {
            container.innerHTML = '<p style="color:var(--text-gray); font-style:italic;">No upcoming bookings.</p>';
            return;
        }

        let html = '';

        tournaments.forEach((t) => {
            html += `<div class="history-item" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.5rem;">
                <div class="history-info">
                    <strong>🏆 ${escHtml(t.title)}</strong>
                    <span>${escHtml(t.division)} &nbsp;·&nbsp; ${t.event_date || 'TBA'} &nbsp;·&nbsp; €${parseFloat(t.entry_fee).toFixed(2)}</span>
                </div>
                <button class="btn-cancel-booking" data-id="${t.id}" data-type="tournament"
                    style="background:#e63946;color:#fff;border:none;padding:0.4rem 1rem;border-radius:4px;cursor:pointer;font-size:0.85rem;font-weight:700;">
                    Cancel
                </button>
            </div>`;
        });

        container.innerHTML = html;

        // Wire cancel buttons
        container.querySelectorAll('.btn-cancel-booking').forEach((btn) => {
            btn.addEventListener('click', async () => {
                const label = 'tournament registration';
                if (!confirm(`Are you sure you want to cancel this ${label}? This cannot be undone.`)) return;

                btn.disabled   = true;
                btn.textContent = 'Cancelling…';

                const res = await apiFetch('cancel-booking', {
                    method: 'POST',
                    body: JSON.stringify({
                        booking_id: btn.dataset.id,
                        type:       btn.dataset.type,
                    }),
                });

                if (res.success) {
                    // Remove the booking row
                    btn.closest('.history-item').remove();
                    // Show empty state if nothing left
                    if (!container.querySelector('.history-item')) {
                        container.innerHTML = '<p style="color:var(--text-gray); font-style:italic;">No upcoming bookings.</p>';
                    }
                } else {
                    alert(res.message || 'Could not cancel. Please try again.');
                    btn.disabled   = false;
                    btn.textContent = 'Cancel';
                }
            });
        });
    }
}

// -----------------------------------------------
// Tournaments Page (monthly DPT)
// -----------------------------------------------
const tournamentGrid = document.getElementById('tournament-grid');
if (tournamentGrid) {
    let currentDivisionFilter = 'all';

    async function loadTournaments() {
        let url = 'tournaments?type=monthly';
        if (currentDivisionFilter !== 'all') url += '&division=' + encodeURIComponent(currentDivisionFilter);
        const res = await apiFetch(url);
        if (!res.success) return;

        tournamentGrid.innerHTML = '';
        res.data.forEach((t) => {
            const isFull = t.registered_count >= t.max_players;
            const card = document.createElement('div');
            card.className = 't-card ' + getTourClass(t.category);
            card.dataset.level = t.division;
            card.dataset.tour = 'Monthly';
            card.innerHTML = `
                <div class="t-badge">${escHtml(t.category || 'TOUR')}</div>
                <div class="t-content">
                    <span class="t-division">${escHtml(t.division.toUpperCase())}</span>
                    <h3>${escHtml(t.title)}</h3>
                    <div class="t-stats">
                        <div class="stat"><span>Required</span><strong>${t.required_points}P</strong></div>
                        <div class="stat"><span>Win</span><strong>${t.win_points}P</strong></div>
                    </div>
                    <div class="point-breakdown">
                        <span>Final: ${t.final_points}P | Semi: ${t.semi_points}P | QF: ${t.quarter_points}P</span>
                    </div>
                    <div class="t-spots">${t.registered_count}/${t.max_players} registered</div>
                    <button class="btn btn-primary btn-block reg-btn" data-id="${t.id}" data-req="${t.required_points}" ${isFull ? 'disabled' : ''}>
                        ${isFull ? 'Full' : 'Register Team'}
                    </button>
                </div>`;
            tournamentGrid.appendChild(card);
        });

        attachTournamentRegButtons();
    }

    function getTourClass(category) {
        if (!category) return '';
        const c = category.toLowerCase();
        if (c.includes('gold')) return 'gold';
        if (c.includes('silver')) return 'silver';
        if (c.includes('finale')) return 'finale';
        return '';
    }

    function attachTournamentRegButtons() {
        document.querySelectorAll('.reg-btn[data-id]').forEach((btn) => {
            btn.addEventListener('click', async () => {
                const id = btn.dataset.id;
                const res = await apiFetch('tournaments/register', {
                    method: 'POST',
                    body: JSON.stringify({ tournament_id: id }),
                });
                showStatusModal(res.success, res.message);
            });
        });
    }

    // Division filter radios
    document.querySelectorAll('input[name="level"]').forEach((radio) => {
        radio.addEventListener('change', () => {
            const val = radio.value;
            // Map radio value to division name
            const divMap = { A: 'Professional', B: 'Advanced', C: 'Intermediate', D: 'Beginner', Women: 'Women', all: 'all' };
            currentDivisionFilter = divMap[val] || val;
            loadTournaments();
        });
    });

    loadTournaments();
}

function showStatusModal(success, message) {
    const modal = document.getElementById('status-modal');
    if (!modal) {
        alert(message);
        return;
    }
    const titleEl = document.getElementById('modal-title');
    const msgEl   = document.getElementById('modal-msg');
    if (titleEl) titleEl.textContent = success ? 'Success' : 'Notice';
    if (msgEl) msgEl.textContent = message;
    modal.classList.add('active');
}

// -----------------------------------------------
// Weekly Tournament Page
// -----------------------------------------------
const weeklyGrid = document.querySelector('.weekly-grid');
if (weeklyGrid) {
    let selectedTournamentId = null;

    async function loadWeeklyTournaments(division = '') {
        let url = 'tournaments?type=weekly';
        if (division) url += '&division=' + encodeURIComponent(division);
        const res = await apiFetch(url);
        if (!res.success) return;

        weeklyGrid.innerHTML = '';
        res.data.forEach((t) => {
            const isFull = t.registered_count >= t.max_players;
            const card = document.createElement('div');
            card.className = 'weekly-card';
            card.dataset.level = t.division;
            card.innerHTML = `
                <div class="card-tag">WEEKLY</div>
                <div class="card-main-info">
                    <div class="card-text">
                        <span class="card-division">${escHtml(t.division)}</span>
                        <h3>${escHtml(t.title)}</h3>
                        <p class="card-date">${t.event_date || ''}</p>
                    </div>
                    <div class="card-stats">
                        <div class="c-stat"><span>Entry Fee</span><strong>€${parseFloat(t.entry_fee).toFixed(2)}</strong></div>
                        <div class="c-stat"><span>Win Points</span><strong>${t.win_points}P</strong></div>
                        <div class="c-stat"><span>Spots</span><strong>${t.registered_count}/${t.max_players}</strong></div>
                    </div>
                    <button class="btn btn-primary btn-slim reg-btn" data-id="${t.id}" data-fee="${t.entry_fee}" ${isFull ? 'disabled' : ''}>
                        ${isFull ? 'Full' : 'Register'}
                    </button>
                </div>`;
            weeklyGrid.appendChild(card);
        });

        document.querySelectorAll('.weekly-grid .reg-btn').forEach((btn) => {
            btn.addEventListener('click', () => {
                selectedTournamentId = btn.dataset.id;
                const fee = parseFloat(btn.dataset.fee).toFixed(2);
                const descEl = document.getElementById('checkout-desc');
                const amtEl  = document.getElementById('checkout-amount');
                if (descEl) descEl.textContent = 'Weekly Tournament Registration';
                if (amtEl) amtEl.textContent = '€' + fee;
                openModal('checkout-modal');
            });
        });
    }

    // Filter radios
    document.querySelectorAll('input[name="lvl"]').forEach((radio) => {
        radio.addEventListener('change', () => {
            const divMap = { C: 'Intermediate', B: 'Advanced', '': 'all' };
            loadWeeklyTournaments(divMap[radio.value] || '');
        });
    });

    // Checkout form
    const checkoutForm = document.getElementById('checkout-form');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            if (!selectedTournamentId) return;
            closeModal('checkout-modal');
            const res = await apiFetch('tournaments/register', {
                method: 'POST',
                body: JSON.stringify({ tournament_id: selectedTournamentId }),
            });
            if (res.success) {
                openModal('confirmation-modal');
            } else {
                showStatusModal(false, res.message);
            }
        });
    }

    const btnCloseConf = document.getElementById('btn-close-confirmation');
    if (btnCloseConf) btnCloseConf.addEventListener('click', () => closeModal('confirmation-modal'));

    loadWeeklyTournaments();
}

// -----------------------------------------------
// Rankings Page
// -----------------------------------------------
const mixedTable = document.getElementById('mixed-levels');
const womenTable = document.getElementById('women-division');
if (mixedTable || womenTable) {
    async function loadRankings(gender = null) {
        let url = 'rankings';
        if (gender) url += `?gender=${gender}`;
        const res = await apiFetch(url);
        if (!res.success) return;
        return res.data;
    }

    async function renderWomenRankings() {
        const data = await loadRankings('female');
        if (!data || !womenTable) return;
        const tbody = womenTable.querySelector('tbody');
        if (!tbody) return;
        if (data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5">No players found.</td></tr>';
            return;
        }
        tbody.innerHTML = data.map((p) => `
            <tr>
                <td>#${p.rank}</td>
                <td>${escHtml(p.full_name)}</td>
                <td>${escHtml(p.division)}</td>
                <td>${p.points}P</td>
                <td>Active</td>
            </tr>`).join('');
    }

    // Tab switching
    document.querySelectorAll('.rank-tab-btn').forEach((btn) => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.rank-tab-btn').forEach((b) => b.classList.remove('active'));
            document.querySelectorAll('.rank-tab-content').forEach((c) => c.classList.remove('active'));
            btn.classList.add('active');
            const target = document.getElementById(btn.dataset.target);
            if (target) target.classList.add('active');

            if (btn.dataset.target === 'women-division') {
                renderWomenRankings();
            }
        });
    });
}

// -----------------------------------------------
// Admin Page
// -----------------------------------------------
if (document.querySelector('.admin-page')) {
    (async () => {
        // Verify admin session
        const sessionRes = await apiFetch('session');
        if (!sessionRes.success || !sessionRes.data || sessionRes.data.role !== 'admin') {
            window.location.href = 'log_in.html';
            return;
        }
        setCsrfToken(sessionRes.data.csrf_token);

        // ----------------------------------------------------------
        // Edit-tournament modal helpers
        // ----------------------------------------------------------
        function openEditModal(t) {
            document.getElementById('edit-t-id').value       = t.id;
            document.getElementById('edit-t-title').value    = t.title;
            document.getElementById('edit-t-type').value     = t.type;
            document.getElementById('edit-t-category').value = t.category || '';
            document.getElementById('edit-t-division').value = t.division;
            document.getElementById('edit-t-status').value   = t.status;
            document.getElementById('edit-t-date').value     = t.event_date ? t.event_date.slice(0, 10) : '';
            document.getElementById('edit-t-fee').value      = t.entry_fee || 0;
            document.getElementById('edit-t-max').value      = t.max_players || 0;
            document.getElementById('edit-t-win').value      = t.win_points || 0;
            openModal('edit-tournament-modal');
        }

        // ----------------------------------------------------------
        // Render a shared row (used by both overview & manage tables)
        // ----------------------------------------------------------
        function tournamentRow(t, showDivision = false) {
            const statusClass = t.status === 'live' ? 'active' : t.status === 'closed' ? '' : 'pending';
            const divCell = showDivision ? `<td>${escHtml(t.division)}</td>` : '';
            const dateCell = showDivision ? `<td>${t.event_date ? t.event_date.slice(0, 10) : '—'}</td>` : '';
            return `<tr>
                <td><strong>${escHtml(t.title)}</strong></td>
                <td>${t.type.charAt(0).toUpperCase() + t.type.slice(1)}</td>
                ${divCell}
                <td>${t.registered_count}/${t.max_players}</td>
                ${dateCell}
                <td class="status-tag ${statusClass}">${t.status.charAt(0).toUpperCase() + t.status.slice(1)}</td>
                <td style="white-space:nowrap;">
                    <button class="btn-icon edit-t-btn" data-t='${JSON.stringify(t)}' title="Edit">✎</button>
                    <button class="btn-icon delete-t-btn" data-id="${t.id}" data-title="${escHtml(t.title)}" title="Delete" style="margin-left:4px;color:#e74c3c;">✕</button>
                </td>
            </tr>`;
        }

        // ----------------------------------------------------------
        // Load dashboard stats + overview tournament table
        // ----------------------------------------------------------
        async function loadDashboard() {
            const res = await apiFetch('admin/dashboard');
            if (!res.success) return;
            const d = res.data;

            const statValues = document.querySelectorAll('.stat-value');
            if (statValues[0]) statValues[0].textContent = d.total_players.toLocaleString();
            if (statValues[1]) statValues[1].textContent = d.active_events;
            if (statValues[2]) statValues[2].textContent = d.pending_scores;

            const statTrends = document.querySelectorAll('.stat-trend');
            if (statTrends[1]) statTrends[1].textContent = d.monthly_count + ' Monthly / ' + d.weekly_count + ' Weekly';

            // Render overview tournaments table
            const tbody = document.querySelector('#overview .admin-table tbody');
            if (tbody && d.tournaments) {
                tbody.innerHTML = d.tournaments.map((t) => tournamentRow(t)).join('');
                wireEditDeleteButtons(tbody);
            }
        }

        // ----------------------------------------------------------
        // Load all tournaments into the Manage Tournaments tab
        // ----------------------------------------------------------
        async function loadTournaments() {
            const res = await apiFetch('tournaments');
            const tbody = document.querySelector('#manage-tournaments-table tbody');
            if (!tbody) return;
            if (!res.success || !res.data.length) {
                tbody.innerHTML = '<tr><td colspan="7" style="text-align:center;color:#999;">No tournaments found.</td></tr>';
                return;
            }
            tbody.innerHTML = res.data.map((t) => tournamentRow(t, true)).join('');
            wireEditDeleteButtons(tbody);
        }

        // ----------------------------------------------------------
        // Wire edit & delete buttons inside a given container
        // ----------------------------------------------------------
        function wireEditDeleteButtons(container) {
            container.querySelectorAll('.edit-t-btn').forEach((btn) => {
                btn.addEventListener('click', () => {
                    const t = JSON.parse(btn.dataset.t);
                    openEditModal(t);
                });
            });
            container.querySelectorAll('.delete-t-btn').forEach((btn) => {
                btn.addEventListener('click', () => {
                    const id    = btn.dataset.id;
                    const title = btn.dataset.title;
                    document.getElementById('delete-tournament-msg').textContent =
                        'Are you sure you want to permanently delete "' + title + '"? This cannot be undone.';
                    document.getElementById('confirm-delete-btn').onclick = async () => {
                        closeModal('delete-tournament-modal');
                        const res = await apiFetch('admin/tournaments/delete', {
                            method: 'POST',
                            body: JSON.stringify({ id }),
                        });
                        showStatusModal(res.success, res.message);
                        if (res.success) {
                            loadDashboard();
                            loadTournaments();
                        }
                    };
                    openModal('delete-tournament-modal');
                });
            });
        }

        // Load players list
        async function loadPlayers(search = '') {
            let url = 'admin/players';
            if (search) url += '?search=' + encodeURIComponent(search);
            const res = await apiFetch(url);
            if (!res.success) return;

            const tbody = document.querySelector('#players .admin-table tbody');
            if (!tbody) return;
            tbody.innerHTML = res.data.map((p) => `
                <tr>
                    <td><strong>${escHtml(p.full_name)}</strong></td>
                    <td>${escHtml(p.email)}</td>
                    <td>${escHtml(p.division)}</td>
                    <td>${p.points.toLocaleString()}</td>
                    <td><button class="btn-icon" data-player-id="${p.id}" data-player-name="${escHtml(p.full_name)}">Edit</button></td>
                </tr>`).join('');
        }

        // Admin sidebar navigation
        document.querySelectorAll('.admin-link').forEach((link) => {
            link.addEventListener('click', (e) => {
                const href = link.getAttribute('href');
                if (!href || !href.startsWith('#')) return;
                e.preventDefault();

                document.querySelectorAll('.admin-link').forEach((l) => l.classList.remove('active'));
                document.querySelectorAll('.admin-view').forEach((v) => v.classList.remove('active'));

                link.classList.add('active');
                const viewId = href.slice(1);
                const view = document.getElementById(viewId);
                if (view) view.classList.add('active');

                if (viewId === 'players') loadPlayers();
                if (viewId === 'tournaments') loadTournaments();
            });
        });

        // Search bar for players
        const searchBar = document.querySelector('.admin-search-bar');
        if (searchBar) {
            let searchTimer;
            searchBar.addEventListener('input', () => {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => loadPlayers(searchBar.value), 400);
            });
        }

        // Create tournament form (modal)
        const adminForm = document.querySelector('#event-modal .admin-form');
        if (adminForm) {
            adminForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const payload = {
                    title:    adminForm.querySelector('[name="title"]')?.value,
                    type:     adminForm.querySelector('[name="type"]')?.value,
                    category: adminForm.querySelector('[name="category"]')?.value,
                    division: adminForm.querySelector('[name="division"]')?.value,
                    event_date: adminForm.querySelector('[name="event_date"]')?.value,
                    entry_fee:   adminForm.querySelector('[name="entry_fee"]')?.value,
                    max_players: adminForm.querySelector('[name="max_players"]')?.value,
                    win_points:  adminForm.querySelector('[name="win_points"]')?.value,
                };
                const res = await apiFetch('admin/tournaments', {
                    method: 'POST',
                    body: JSON.stringify(payload),
                });
                closeModal('event-modal');
                showStatusModal(res.success, res.message);
                if (res.success) {
                    adminForm.reset();
                    loadDashboard();
                    loadTournaments();
                }
            });
        }

        // Edit tournament form (modal)
        const editForm = document.getElementById('edit-tournament-form');
        if (editForm) {
            editForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const payload = {
                    id:          editForm.querySelector('[name="id"]')?.value,
                    title:       editForm.querySelector('[name="title"]')?.value,
                    type:        editForm.querySelector('[name="type"]')?.value,
                    category:    editForm.querySelector('[name="category"]')?.value,
                    division:    editForm.querySelector('[name="division"]')?.value,
                    status:      editForm.querySelector('[name="status"]')?.value,
                    event_date:  editForm.querySelector('[name="event_date"]')?.value,
                    entry_fee:   editForm.querySelector('[name="entry_fee"]')?.value,
                    max_players: editForm.querySelector('[name="max_players"]')?.value,
                    win_points:  editForm.querySelector('[name="win_points"]')?.value,
                };
                const res = await apiFetch('admin/tournaments/update', {
                    method: 'POST',
                    body: JSON.stringify(payload),
                });
                closeModal('edit-tournament-modal');
                showStatusModal(res.success, res.message);
                if (res.success) {
                    loadDashboard();
                    loadTournaments();
                }
            });
        }

        // Adjust rankings form
        const rankForm = document.querySelector('#rankings .score-entry-form');
        if (rankForm) {
            rankForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const payload = {
                    user_id: rankForm.querySelector('[name="player_id"]')?.value,
                    points:  rankForm.querySelector('[name="points"]')?.value,
                    type:    rankForm.querySelector('input[name="adj"]:checked')?.value || 'addition',
                    reason:  rankForm.querySelector('[name="reason"]')?.value,
                };
                const res = await apiFetch('admin/adjust-ranking', {
                    method: 'POST',
                    body: JSON.stringify(payload),
                });
                showStatusModal(res.success, res.message);
            });
        }

        // Logout
        const logoutLink = document.getElementById('admin-logout-btn')
            || document.querySelector('.nav a[href*="sign-up"], .nav a[href*="sign_up"]');
        if (logoutLink) {
            logoutLink.addEventListener('click', async (e) => {
                e.preventDefault();
                await apiFetch('logout', { method: 'POST' });
                window.location.href = 'index.html';
            });
        }

        loadDashboard();
    })();
}

// -----------------------------------------------
// Run nav update on every page
// -----------------------------------------------
updateNav();

// -----------------------------------------------
// Forgot Password Page
// -----------------------------------------------
const forgotForm = document.getElementById('forgot-password-form');
if (forgotForm) {
    const msgEl = document.getElementById('forgot-msg');

    forgotForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (msgEl) { msgEl.style.display = 'none'; }

        const email = forgotForm.querySelector('[name="email"]')?.value.trim();
        const res   = await apiFetch('forgot-password', {
            method: 'POST',
            body: JSON.stringify({ email }),
        });

        if (msgEl) {
            msgEl.textContent    = res.message || (res.success ? 'Check your inbox.' : 'Something went wrong.');
            msgEl.style.color    = res.success ? '#2ecc71' : '#e74c3c';
            msgEl.style.display  = 'block';
        }
        if (res.success) forgotForm.reset();
    });
}

// -----------------------------------------------
// Reset Password Page
// -----------------------------------------------
const resetForm = document.getElementById('reset-password-form');
if (resetForm) {
    const msgEl = document.getElementById('reset-msg');

    // Pull token from URL query string and inject into hidden field
    const urlToken = new URLSearchParams(window.location.search).get('token') || '';
    const tokenInput = document.getElementById('reset-token');
    if (tokenInput) tokenInput.value = urlToken;

    if (!urlToken) {
        if (msgEl) {
            msgEl.textContent   = 'Invalid or missing reset token. Please request a new password reset link.';
            msgEl.style.color   = '#e74c3c';
            msgEl.style.display = 'block';
        }
        resetForm.querySelector('button[type="submit"]').disabled = true;
    }

    resetForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (msgEl) { msgEl.style.display = 'none'; }

        const newPassword     = resetForm.querySelector('[name="new_password"]')?.value;
        const confirmPassword = resetForm.querySelector('[name="confirm_password"]')?.value;

        if (newPassword !== confirmPassword) {
            if (msgEl) {
                msgEl.textContent   = 'Passwords do not match.';
                msgEl.style.color   = '#e74c3c';
                msgEl.style.display = 'block';
            }
            return;
        }

        const res = await apiFetch('reset-password', {
            method: 'POST',
            body: JSON.stringify({ token: urlToken, password: newPassword }),
        });

        if (msgEl) {
            msgEl.textContent   = res.message || (res.success ? 'Password reset!' : 'Something went wrong.');
            msgEl.style.color   = res.success ? '#2ecc71' : '#e74c3c';
            msgEl.style.display = 'block';
        }
        if (res.success) {
            resetForm.reset();
            setTimeout(() => { window.location.href = 'log_in.html'; }, 2000);
        }
    });
}
