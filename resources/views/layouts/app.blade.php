<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PADEL ACE — Book Courts & Join Tournaments')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}?v={{ time() }}">
    @stack('styles')
</head>
<body>
    <header class="header">
        <a href="{{ url('/') }}" class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Y-PADEL Logo" class="main-logo">
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
                <img src="{{ asset('images/logo.png') }}" alt="Y-PADEL Logo" class="footer-logo">
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
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>

            <div class="footer-col social">
                <h4 class="col-title">Connect</h4>
                <p>Follow us on Social Media</p>
                <div class="social-icons">
                    </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
    @stack('scripts')
</body>
</html>