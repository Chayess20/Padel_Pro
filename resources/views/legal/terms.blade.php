@extends('layouts.app')

@section('title', 'Terms of Service — PADEL ACE')

@section('content')
<div class="page-layout-wrapper">
    <section class="section">
        <h1 class="section-title">Terms of Service</h1>

        <div class="auth-card" style="max-width: 760px; margin: 0 auto;">
            <p style="color: rgba(255,255,255,0.7); margin-bottom: 1.5rem;">
                Last updated: {{ date('F j, Y') }}
            </p>

            <h2 style="color: #fff; margin-bottom: 0.75rem;">1. Acceptance of Terms</h2>
            <p style="color: rgba(255,255,255,0.7); margin-bottom: 1.5rem;">
                By accessing or using PADEL ACE, you agree to be bound by these Terms of Service.
                If you do not agree to all terms, please do not use our platform.
            </p>

            <h2 style="color: #fff; margin-bottom: 0.75rem;">2. Use of the Platform</h2>
            <p style="color: rgba(255,255,255,0.7); margin-bottom: 1.5rem;">
                You must be at least 18 years old to register. You agree to provide accurate
                information and to keep your account secure.
            </p>

            <h2 style="color: #fff; margin-bottom: 0.75rem;">3. Tournament Registrations</h2>
            <p style="color: rgba(255,255,255,0.7); margin-bottom: 1.5rem;">
                Entry fees are non-refundable unless a tournament is cancelled by the organiser.
                PADEL ACE reserves the right to modify or cancel events at any time.
            </p>

            <h2 style="color: #fff; margin-bottom: 0.75rem;">4. Contact</h2>
            <p style="color: rgba(255,255,255,0.7);">
                Questions about these terms? <a href="{{ route('legal.contact') }}" style="color: #fff;">Contact us</a>.
            </p>
        </div>
    </section>
</div>
@endsection
