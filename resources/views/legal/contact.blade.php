@extends('layouts.app')

@section('title', 'Contact Us — PADEL ACE')

@section('content')
<div class="page-layout-wrapper">
    <section class="section">
        <h1 class="section-title">Contact Us</h1>

        <div class="auth-card" style="max-width: 560px; margin: 0 auto;">
            <p style="color: rgba(255,255,255,0.7); margin-bottom: 2rem;">
                Have a question or need support? Reach out to the PADEL ACE team.
            </p>

            @if(session('success'))
                <p style="color: #68d391; margin-bottom: 1.5rem;">{{ session('success') }}</p>
            @endif

            <form method="POST" action="{{ route('legal.contact.submit') }}">
                @csrf
                <div class="form-group">
                    <label for="contact-name">Full Name</label>
                    <input id="contact-name" type="text" name="name" value="{{ old('name') }}"
                           required autocomplete="name"
                           class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
                    @error('name')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="contact-email">Email Address</label>
                    <input id="contact-email" type="email" name="email" value="{{ old('email') }}"
                           required autocomplete="email"
                           class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                    @error('email')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="contact-message">Message</label>
                    <textarea id="contact-message" name="message" rows="5" required
                        class="{{ $errors->has('message') ? 'is-invalid' : '' }}"
                        style="width:100%; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.12);
                               border-radius:0.5rem; color:#fff; font-size:0.95rem; padding:0.7rem 1rem;
                               outline:none; resize:vertical; box-sizing:border-box;">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-login">Send Message</button>
            </form>
        </div>
    </section>
</div>
@endsection
