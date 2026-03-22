@extends('layouts.app')

@section('title', 'Terms of Service — PADEL ACE')

@section('content')
<div style="max-width:860px; margin:4rem auto; padding:0 1.5rem; color:var(--navy);">
    <h1 style="font-family:var(--font-heading); font-size:2.5rem; margin-bottom:0.5rem;">Terms of Service</h1>
    <p style="color:var(--text-gray); margin-bottom:2.5rem;">Last updated: {{ date('F Y') }}</p>

    <section style="margin-bottom:2rem;">
        <h2 style="font-family:var(--font-heading); font-size:1.4rem; margin-bottom:0.75rem;">1. Acceptance of Terms</h2>
        <p>By creating an account or using the PADEL ACE platform ("Service"), you agree to be bound by these Terms of Service. If you do not agree, please do not use the Service.</p>
    </section>

    <section style="margin-bottom:2rem;">
        <h2 style="font-family:var(--font-heading); font-size:1.4rem; margin-bottom:0.75rem;">2. Eligibility</h2>
        <p>You must be at least 16 years old to register an account. By registering, you confirm that you meet this requirement.</p>
    </section>

    <section style="margin-bottom:2rem;">
        <h2 style="font-family:var(--font-heading); font-size:1.4rem; margin-bottom:0.75rem;">3. User Accounts</h2>
        <p>You are responsible for maintaining the confidentiality of your account credentials and for all activity that occurs under your account. You must notify us immediately of any unauthorised use of your account.</p>
    </section>

    <section style="margin-bottom:2rem;">
        <h2 style="font-family:var(--font-heading); font-size:1.4rem; margin-bottom:0.75rem;">4. Tournament Registrations</h2>
        <p>By registering for a tournament you confirm that you meet any stated eligibility requirements (e.g. division, points). Entry fees, where applicable, must be paid as instructed. Registrations may be cancelled up until the tournament start date.</p>
    </section>

    <section style="margin-bottom:2rem;">
        <h2 style="font-family:var(--font-heading); font-size:1.4rem; margin-bottom:0.75rem;">5. Code of Conduct</h2>
        <p>All players are expected to behave respectfully towards other participants, organisers, and staff. PADEL ACE reserves the right to suspend or ban accounts that violate this code.</p>
    </section>

    <section style="margin-bottom:2rem;">
        <h2 style="font-family:var(--font-heading); font-size:1.4rem; margin-bottom:0.75rem;">6. Rankings & Points</h2>
        <p>Rankings and points are managed by PADEL ACE administrators. Point allocations are final unless an administrative error is identified and reported within 7 days of the event.</p>
    </section>

    <section style="margin-bottom:2rem;">
        <h2 style="font-family:var(--font-heading); font-size:1.4rem; margin-bottom:0.75rem;">7. Limitation of Liability</h2>
        <p>PADEL ACE provides the Service on an "as is" basis. We are not liable for any indirect, incidental, or consequential damages arising from your use of the Service.</p>
    </section>

    <section style="margin-bottom:2rem;">
        <h2 style="font-family:var(--font-heading); font-size:1.4rem; margin-bottom:0.75rem;">8. Changes to These Terms</h2>
        <p>We may update these terms from time to time. Continued use of the Service after changes are posted constitutes acceptance of the new terms.</p>
    </section>

    <section style="margin-bottom:2rem;">
        <h2 style="font-family:var(--font-heading); font-size:1.4rem; margin-bottom:0.75rem;">9. Contact</h2>
        <p>For questions about these terms, please contact us via the details in the footer of this website.</p>
    </section>
</div>
@endsection
