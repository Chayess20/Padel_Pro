@extends('layouts.app')

@section('title', 'Privacy Policy — PADEL ACE')

@section('content')
<div class="page-layout-wrapper">
    <section class="section">
        <h1 class="section-title">Privacy Policy</h1>

        <div class="auth-card" style="max-width: 760px; margin: 0 auto;">
            <p style="color: rgba(255,255,255,0.7); margin-bottom: 1.5rem;">
                Last updated: {{ date('F j, Y') }}
            </p>

            <h2 style="color: #fff; margin-bottom: 0.75rem;">1. Information We Collect</h2>
            <p style="color: rgba(255,255,255,0.7); margin-bottom: 1.5rem;">
                We collect information you provide directly — such as your name, email address,
                and payment details — when you register or book a tournament.
            </p>

            <h2 style="color: #fff; margin-bottom: 0.75rem;">2. How We Use Your Information</h2>
            <p style="color: rgba(255,255,255,0.7); margin-bottom: 1.5rem;">
                Your data is used solely to operate the PADEL ACE platform: managing your account,
                processing registrations, and maintaining rankings. We do not sell your data.
            </p>

            <h2 style="color: #fff; margin-bottom: 0.75rem;">3. Data Security</h2>
            <p style="color: rgba(255,255,255,0.7); margin-bottom: 1.5rem;">
                We implement industry-standard security measures to protect your personal information.
                Passwords are hashed and never stored in plain text.
            </p>

            <h2 style="color: #fff; margin-bottom: 0.75rem;">4. Contact</h2>
            <p style="color: rgba(255,255,255,0.7);">
                Privacy questions? <a href="{{ route('legal.contact') }}" style="color: #fff;">Contact us</a>.
            </p>
        </div>
    </section>
</div>
@endsection
