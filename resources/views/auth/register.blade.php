@extends('layouts.app')

@section('title', 'Sign Up — PADEL ACE')

@section('content')
<section class="auth-section">
    <div class="auth-card">
        <h1 class="auth-title">Join PADEL ACE</h1>
        <p class="auth-subtitle">Create your account to compete in tournaments and track your ranking.</p>

        @if ($errors->any())
            <div class="auth-errors">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="auth-form">
            @csrf

            <div class="input-group">
                <label for="name">Full Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    placeholder="Your Name"
                >
            </div>

            <div class="input-group">
                <label for="email">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    placeholder="you@example.com"
                >
            </div>

            <div class="input-group">
                <label for="phone">Phone Number <span class="optional">(optional)</span></label>
                <input
                    type="tel"
                    id="phone"
                    name="phone"
                    value="{{ old('phone') }}"
                    placeholder="+49 000 000 000"
                >
            </div>

            <div class="input-group">
                <label for="gender">Gender <span class="optional">(optional)</span></label>
                <select id="gender" name="gender">
                    <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select gender</option>
                    <option value="male"   {{ old('gender') === 'male'   ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other"  {{ old('gender') === 'other'  ? 'selected' : '' }}>Prefer not to say</option>
                </select>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    placeholder="Min. 8 characters"
                >
            </div>

            <div class="input-group">
                <label for="password_confirmation">Confirm Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                    placeholder="Repeat your password"
                >
            </div>

            <button type="submit" class="btn btn-primary btn-block">Create Account</button>
        </form>

        <p class="auth-switch">
            Already have an account?
            <a href="{{ route('login') }}">Log in</a>
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
        max-width: 480px;
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

    .auth-form .input-group input,
    .auth-form .input-group select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #E2E8F0;
        border-radius: 6px;
        font-family: var(--font-body);
        font-size: 0.95rem;
        color: var(--navy);
        box-sizing: border-box;
        transition: border-color 0.2s;
        background: #fff;
    }

    .auth-form .input-group input:focus,
    .auth-form .input-group select:focus {
        outline: none;
        border-color: var(--navy);
    }

    .auth-form .optional {
        font-weight: 400;
        text-transform: none;
        color: var(--text-gray);
        font-size: 0.78rem;
        letter-spacing: 0;
    }

    .auth-form .btn-block {
        width: 100%;
        padding: 0.9rem;
        font-size: 1rem;
        margin-top: 0.5rem;
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
