@extends('layouts.app')

@section('title', 'Sign Up — PADEL ACE')

@section('content')
<section class="auth-page">
    <div class="auth-container">
        <h2 style="font-family:var(--font-heading); font-size:1.8rem; margin-bottom:0.25rem; color:var(--navy);">Create Your Account</h2>
        <p style="color:var(--text-gray); font-size:0.9rem; margin-bottom:1.75rem;">Join the PADEL ACE community and start competing.</p>

        <p id="signup-message" style="display:none; margin-bottom:1rem; font-weight:500;"></p>

        <form id="signup-form" novalidate>
            @csrf
            <div class="input-group" style="margin-bottom:1rem;">
                <label for="reg-name">Full Name</label>
                <input id="reg-name" type="text" name="full_name" placeholder="Your full name" required>
            </div>

            <div class="input-group" style="margin-bottom:1rem;">
                <label for="reg-email">Email Address</label>
                <input id="reg-email" type="email" name="email" placeholder="you@example.com" required>
            </div>

            <div class="input-row">
                <div class="input-group">
                    <label for="reg-phone">Phone (optional)</label>
                    <input id="reg-phone" type="tel" name="phone" placeholder="+49 123 456 789">
                </div>
                <div class="input-group">
                    <label for="reg-gender">Gender</label>
                    <select id="reg-gender" name="gender">
                        <option value="">Select…</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
            </div>

            <div class="input-group" style="margin-bottom:1rem;">
                <label for="reg-national">National Ranking</label>
                <select id="reg-national" name="national_ranking">
                    <option value="0">No national ranking</option>
                    <option value="1">I have a national ranking</option>
                </select>
            </div>

            <div class="input-group" style="margin-bottom:1.5rem;">
                <label for="reg-password">Password <span style="font-weight:400; color:var(--text-gray);">(min. 8 characters)</span></label>
                <input id="reg-password" type="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%; padding:0.85rem; font-size:1rem;">
                Create Account
            </button>
        </form>

        <p style="margin-top:1.25rem; font-size:0.88rem; text-align:center; color:var(--text-gray);">
            Already have an account?
            <a href="{{ route('login') }}" style="color:var(--navy); font-weight:700; text-decoration:underline;">Log In</a>
        </p>
    </div>
</section>
@endsection
