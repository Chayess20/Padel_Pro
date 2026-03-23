@extends('layouts.app')

@section('title', 'Log In — PADEL ACE')

@push('styles')
<style>
    .auth-section {
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4rem 1.5rem;
    }

    .auth-card {
        background: var(--color-surface, #1a1a2e);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 1rem;
        padding: 2.5rem 2rem;
        width: 100%;
        max-width: 420px;
    }

    .auth-card h1 {
        font-family: var(--font-heading, 'Bebas Neue', sans-serif);
        font-size: 2.25rem;
        color: #fff;
        margin-bottom: 0.25rem;
        letter-spacing: 0.05em;
    }

    .auth-card .auth-subtitle {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.875rem;
        margin-bottom: 2rem;
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-group label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: rgba(255, 255, 255, 0.6);
        margin-bottom: 0.4rem;
    }

    .form-group input {
        width: 100%;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 0.5rem;
        color: #fff;
        font-size: 0.95rem;
        padding: 0.7rem 1rem;
        outline: none;
        transition: border-color 0.2s;
        box-sizing: border-box;
    }

    .form-group input:focus {
        border-color: rgba(255, 255, 255, 0.4);
    }

    .form-group input.is-invalid {
        border-color: #e53e3e;
    }

    .invalid-feedback {
        color: #fc8181;
        font-size: 0.8rem;
        margin-top: 0.3rem;
    }

    .form-remember {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
        color: rgba(255, 255, 255, 0.6);
    }

    .form-remember input[type="checkbox"] {
        width: auto;
        accent-color: #fff;
    }

    .btn-login {
        width: 100%;
        padding: 0.8rem;
        font-family: var(--font-heading, 'Bebas Neue', sans-serif);
        font-size: 1.1rem;
        letter-spacing: 0.1em;
        cursor: pointer;
        border: none;
    }
</style>
@endpush

@section('content')
<section class="auth-section">
    <div class="auth-card">
        <h1>Log In</h1>
        <p class="auth-subtitle">Welcome back to PADEL ACE</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                >
                @error('email')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                >
                @error('password')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-remember">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember" style="margin-bottom:0;">Remember me</label>
            </div>

            <button type="submit" class="btn btn-primary btn-login">
                Log In
            </button>
        </form>
    </div>
</section>
@endsection
