@extends('layouts.app')

@section('title', 'Forgot Password — PADEL ACE')

@section('content')
<section class="auth-page">
    <div class="auth-container">
        <h2 style="font-family:var(--font-heading); font-size:1.8rem; margin-bottom:0.25rem; color:var(--navy);">Reset Password</h2>
        <p style="color:var(--text-gray); font-size:0.9rem; margin-bottom:1.75rem;">Enter your email and we'll send you a reset link.</p>

        <p id="forgot-msg" style="display:none; margin-bottom:1rem; font-weight:500;"></p>

        <form id="forgot-password-form" novalidate>
            @csrf
            <div class="input-group" style="margin-bottom:1.5rem;">
                <label for="forgot-email">Email Address</label>
                <input id="forgot-email" type="email" name="email" placeholder="you@example.com" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%; padding:0.85rem; font-size:1rem;">
                Send Reset Link
            </button>
        </form>

        <p style="margin-top:1.25rem; font-size:0.88rem; text-align:center; color:var(--text-gray);">
            Remembered your password?
            <a href="{{ route('login') }}" style="color:var(--navy); font-weight:700; text-decoration:underline;">Log In</a>
        </p>
    </div>
</section>
@endsection
