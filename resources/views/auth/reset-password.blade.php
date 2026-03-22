@extends('layouts.app')

@section('title', 'Reset Password — PADEL ACE')

@section('content')
<section class="auth-page">
    <div class="auth-container">
        <h2 style="font-family:var(--font-heading); font-size:1.8rem; margin-bottom:0.25rem; color:var(--navy);">Set New Password</h2>
        <p style="color:var(--text-gray); font-size:0.9rem; margin-bottom:1.75rem;">Choose a strong password for your account.</p>

        <p id="reset-msg" style="display:none; margin-bottom:1rem; font-weight:500;"></p>

        <form id="reset-password-form" novalidate>
            @csrf
            {{-- Token and email are read from the URL query string by script.js --}}
            <input id="reset-token" type="hidden" name="token">
            <input id="reset-email" type="hidden" name="email">

            <div class="input-group" style="margin-bottom:1rem;">
                <label for="new-password">New Password <span style="font-weight:400; color:var(--text-gray);">(min. 8 characters)</span></label>
                <input id="new-password" type="password" name="new_password" placeholder="••••••••" required>
            </div>

            <div class="input-group" style="margin-bottom:1.5rem;">
                <label for="confirm-password">Confirm Password</label>
                <input id="confirm-password" type="password" name="confirm_password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%; padding:0.85rem; font-size:1rem;">
                Reset Password
            </button>
        </form>

        <p style="margin-top:1.25rem; font-size:0.88rem; text-align:center; color:var(--text-gray);">
            <a href="{{ route('login') }}" style="color:var(--navy); font-weight:700; text-decoration:underline;">Back to Login</a>
        </p>
    </div>
</section>
@endsection
