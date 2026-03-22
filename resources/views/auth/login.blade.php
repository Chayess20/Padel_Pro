@extends('layouts.app')

@section('title', 'Log In — PADEL ACE')

@section('content')
<section class="auth-page">
    <div class="auth-container">
        <h2 style="font-family:var(--font-heading); font-size:1.8rem; margin-bottom:0.25rem; color:var(--navy);">Welcome Back</h2>
        <p style="color:var(--text-gray); font-size:0.9rem; margin-bottom:1.75rem;">Sign in to your PADEL ACE account.</p>

        <p id="login-message" style="display:none; margin-bottom:1rem; font-weight:500;"></p>

        <form id="login-form" novalidate>
            @csrf
            <div class="input-group" style="margin-bottom:1rem;">
                <label for="login-email">Email Address</label>
                <input id="login-email" type="email" name="email" placeholder="you@example.com" required>
            </div>

            <div class="input-group" style="margin-bottom:1.5rem;">
                <label for="login-password">Password</label>
                <input id="login-password" type="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%; padding:0.85rem; font-size:1rem;">
                Log In
            </button>
        </form>

        <p style="margin-top:1.25rem; font-size:0.88rem; text-align:center; color:var(--text-gray);">
            Don't have an account?
            <a href="{{ route('register') }}" style="color:var(--navy); font-weight:700; text-decoration:underline;">Sign Up</a>
        </p>
        <p style="margin-top:0.5rem; font-size:0.88rem; text-align:center; color:var(--text-gray);">
            <a href="{{ route('password.request') }}" style="color:var(--navy); text-decoration:underline;">Forgot your password?</a>
        </p>
    </div>
</section>
@endsection
