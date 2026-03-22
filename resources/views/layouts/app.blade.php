<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PADEL ACE — Tournaments & Rankings')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}?v={{ time() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
</head>
<body class="@yield('body-class')">
    <header class="header">
        <a href="{{ url('/') }}" class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="PADEL ACE Logo" class="main-logo">
        </a>
        <nav class="nav">
            <a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">Home</a>
            <a href="{{ route('tournaments.index') }}" class="{{ Request::is('tournaments') ? 'active' : '' }}">DPT</a>
            <a href="{{ route('rankings.index') }}" class="{{ Request::is('rankings') ? 'active' : '' }}">Rankings</a>
            <a href="{{ route('tournaments.weekly') }}" class="{{ Request::is('weekly-tournaments') ? 'active' : '' }}">Weekly Tournament</a>
            
            @auth
                <a href="{{ url('/profile') }}">Profile</a>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:none; border:none; color:white; cursor:pointer; font-family:var(--font-heading); font-weight:600; text-transform:uppercase;">Log Out</button>
                </form>
            @else
                <a href="{{ route('login') }}">Log In</a>
                <a href="{{ route('register') }}" class="btn-nav">sign up</a>
            @endauth
        </nav>
        <button class="menu-toggle" aria-label="Toggle menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-col branding">
                <img src="{{ asset('images/logo.png') }}" alt="PADEL ACE Logo" class="footer-logo">
                <p class="footer-text">
                    The premier padel circuit in Dusseldorf. Join the community, 
                    track your ranking, and dominate the court.
                </p>
                <p class="copyright">© {{ date('Y') }} PADEL ACE. All rights reserved.</p>
            </div>

            <div class="footer-col">
                <h4 class="col-title">Explore</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('register') }}">Get Started</a></li>
                    <li><a href="{{ route('tournaments.index') }}">DPT</a></li>
                    <li><a href="{{ route('rankings.index') }}">Rankings</a></li>
                    <li><a href="{{ route('tournaments.weekly') }}">Weekly Tournament</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="col-title">Support</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('legal.terms') }}">Terms of Service</a></li>
                    <li><a href="{{ route('legal.privacy') }}">Privacy Policy</a></li>
                    <li><a href="mailto:contact@padel-ace.com">Contact Us</a></li>
                </ul>
            </div>

            <div class="footer-col social">
                <h4 class="col-title">Connect</h4>
                <p>Follow us on Social Media</p>
                <div class="social-icons">
                    <a href="#" class="social-box" aria-label="Instagram">IG</a>
                    <a href="#" class="social-box" aria-label="WhatsApp">WA</a>
                    <a href="#" class="social-box" aria-label="Facebook">FB</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
    @stack('scripts')

    {{-- GDPR cookie consent banner --}}
    <div id="cookie-banner" style="display:none; position:fixed; bottom:0; left:0; right:0; z-index:9999;
         background:var(--navy); color:var(--white); padding:1rem 1.5rem;
         flex-wrap:wrap; align-items:center; gap:1rem;
         border-top:2px solid var(--neon-yellow); font-size:0.875rem;">
        <p style="margin:0; flex:1; min-width:200px;">
            We use a strictly necessary session cookie to keep you logged in.
            No tracking cookies are used.
            See our <a href="{{ route('legal.privacy') }}" style="color:var(--neon-yellow); text-decoration:underline;">Privacy Policy</a> for details.
        </p>
        <button id="cookie-accept" style="background:var(--neon-yellow); color:var(--navy); border:none;
                padding:0.5rem 1.25rem; border-radius:4px; font-weight:700; cursor:pointer; white-space:nowrap;">
            Got it
        </button>
    </div>
    <script>
        (function () {
            var banner = document.getElementById('cookie-banner');
            if (!localStorage.getItem('cookie_consent')) {
                banner.style.display = 'flex';
            }
            document.getElementById('cookie-accept').addEventListener('click', function () {
                localStorage.setItem('cookie_consent', '1');
                banner.style.display = 'none';
            });
        })();
    </script>
</body>
</html>