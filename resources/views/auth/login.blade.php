@extends('layouts.app')

@section('title', 'Log In — PADEL ACE')

@section('content')
<section class="auth-section">
    <div class="auth-card">
        <h1 class="auth-title">Welcome Back</h1>
        <p class="auth-subtitle">Log in to manage your profile and register for tournaments.</p>

        @if ($errors->any())
            <div class="auth-errors">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf

            <div class="input-group">
                <label for="email">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    placeholder="you@example.com"
                >
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    placeholder="••••••••"
                >
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember me</label>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Log In</button>
        </form>

        <p class="auth-switch">
            Don't have an account?
            <a href="{{ route('register') }}">Sign up</a>
        </p>
    </div>
</section>
@endsection

@push('styles')
<style>
    .auth-section {
        min-height: calc(100vh - 80px);
        background: var(--navy);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
    }

    .auth-card {
        background: var(--white);
        border-radius: 12px;
        padding: 2.5rem;
        width: 100%;
        max-width: 440px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .auth-title {
        font-family: var(--font-display);
        font-size: 2.2rem;
        color: var(--navy);
        margin-bottom: 0.4rem;
    }

    .auth-subtitle {
        font-family: var(--font-body);
        color: var(--text-gray);
        font-size: 0.95rem;
        margin-bottom: 1.8rem;
    }

    .auth-errors {
        background: #FEE2E2;
        border: 1px solid #FECACA;
        border-radius: 6px;
        padding: 0.75rem 1rem;
        margin-bottom: 1.2rem;
        font-size: 0.9rem;
        color: #B91C1C;
    }

    .auth-errors p {
        margin: 0;
    }

    .auth-form .input-group {
        margin-bottom: 1.2rem;
    }

    .auth-form .input-group label {
        display: block;
        font-family: var(--font-heading);
        font-weight: 700;
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--navy);
        margin-bottom: 0.4rem;
    }

    .auth-form .input-group input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #E2E8F0;
        border-radius: 6px;
        font-family: var(--font-body);
        font-size: 0.95rem;
        color: var(--navy);
        box-sizing: border-box;
        transition: border-color 0.2s;
    }

    .auth-form .input-group input:focus {
        outline: none;
        border-color: var(--navy);
    }

    .auth-form .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        font-size: 0.88rem;
        color: var(--text-gray);
        font-family: var(--font-body);
    }

    .auth-form .btn-block {
        width: 100%;
        padding: 0.9rem;
        font-size: 1rem;
    }

    .auth-switch {
        text-align: center;
        margin-top: 1.4rem;
        font-family: var(--font-body);
        font-size: 0.9rem;
        color: var(--text-gray);
    }

    .auth-switch a {
        color: var(--navy);
        font-weight: 700;
        text-decoration: underline;
    }

    .auth-switch a:hover {
        color: var(--neon-hover);
    }
</style>
@endpush
