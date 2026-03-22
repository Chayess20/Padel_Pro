@extends('layouts.app')

@section('title', 'Privacy Policy — PADEL ACE')

@section('content')
<div style="max-width:860px; margin:4rem auto; padding:0 1.5rem; color:var(--navy);">
    <h1 style="font-family:var(--font-heading); font-size:2.5rem; margin-bottom:0.5rem;">Privacy Policy</h1>
    <p style="color:var(--text-gray); margin-bottom:2.5rem;">Last updated: {{ date('F Y') }}</p>

    <section style="margin-bottom:2rem;">
        <h2 style="font-family:var(--font-heading); font-size:1.4rem; margin-bottom:0.75rem;">1. Who We Are</h2>
        <p>PADEL ACE operates the padel tournament and rankings platform accessible at this website. This policy explains how we collect, use, and protect your personal data in compliance with the EU General Data Protection Regulation (GDPR / DSGVO).</p>
    </section>

    <section style="margin-bottom:2rem;">
        <h2 style="font-family:var(--font-heading); font-size:1.4rem; margin-bottom:0.75rem;">2. Data We Collect</h2>
        <ul style="padding-left:1.5rem; line-height:1.8;">
            <li><strong>Account data:</strong> name, email address, phone number, gender, and password (stored as a bcrypt hash).</li>
            <li><strong>Activity data:</strong> tournament registrations, ranking points, and division history.</li>
            <li><strong>Technical data:</strong> session cookies required for authentication, browser type, and IP address stored in server logs.</li>
        </ul>
    </section>

    <section style="margin-bottom:2rem;">
        <h2 style="font-family:var(--font-heading); font-size:1.4rem; margin-bottom:0.75rem;">3. Legal Basis for Processing</h2>
        <p>We process your personal data on the basis of:</p>
        <ul style="padding-left:1.5rem; line-height:1.8;">
            <li><strong>Contract performance</strong> (Art. 6(1)(b) GDPR) — to provide your account and tournament services.</li>
            <li><strong>Legitimate interests</strong> (Art. 6(1)(f) GDPR) — to maintain security and prevent fraud.</li>
            <li><strong>Consent</strong> (Art. 6(1)(a) GDPR) — for optional cookies and marketing communications.</li>
        </ul>
    </section>

    <section style="margin-bottom:2rem;">
        <h2 style="font-family:var(--font-heading); font-size:1.4rem; margin-bottom:0.75rem;">4. How We Use Your Data</h2>
        <ul style="padding-left:1.5rem; line-height:1.8;">
            <li>To manage your account and authenticate you.</li>
            <li>To process tournament registrations and manage rankings.</li>
            <li>To send password reset emails.</li>
            <li>To respond to enquiries.</li>
        </ul>
    </section>

    <section style="margin-bottom:2rem;">
        <h2 style="font-family:var(--font-heading); font-size:1.4rem; margin-bottom:0.75rem;">5. Data Sharing</h2>
        <p>We do not sell your personal data. We do not share your data with third parties except as required by law or with service providers who process it strictly on our behalf (e.g. email delivery).</p>
    </section>

    <section style="margin-bottom:2rem;">
        <h2 style="font-family:var(--font-heading); font-size:1.4rem; margin-bottom:0.75rem;">6. Cookies</h2>
        <p>We use a strictly necessary session cookie to keep you logged in. No third-party tracking or advertising cookies are used without your explicit consent.</p>
    </section>

    <section style="margin-bottom:2rem;">
        <h2 style="font-family:var(--font-heading); font-size:1.4rem; margin-bottom:0.75rem;">7. Data Retention</h2>
        <p>We retain your account data for as long as your account is active. You may request deletion of your account and associated data at any time by contacting us.</p>
    </section>

    <section style="margin-bottom:2rem;">
        <h2 style="font-family:var(--font-heading); font-size:1.4rem; margin-bottom:0.75rem;">8. Your Rights (GDPR)</h2>
        <p>Under GDPR you have the right to: access, rectify, erase, restrict, and port your personal data, and to object to processing. To exercise any of these rights, please contact us.</p>
    </section>

    <section style="margin-bottom:2rem;">
        <h2 style="font-family:var(--font-heading); font-size:1.4rem; margin-bottom:0.75rem;">9. Contact &amp; Complaints</h2>
        <p>For privacy enquiries, contact us via the details in the footer. If you believe we have not complied with your data protection rights, you have the right to lodge a complaint with the relevant supervisory authority (in Germany: the Landesbeauftragte für Datenschutz und Informationsfreiheit of your state).</p>
    </section>
</div>
@endsection
