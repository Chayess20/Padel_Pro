@extends('layouts.app')

@section('title', 'Log In — PADEL ACE')

@section('content')
<div class="page-layout-wrapper" style="display:flex; justify-content:center; align-items:center; min-height:70vh;">
    <div class="profile-card" style="width:100%; max-width:440px;">
        <h1 class="section-title" style="margin-bottom:2rem;">Log In</h1>

        @if($errors->any())
            <div style="color:#ff4d4d; margin-bottom:1rem;">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div style="margin-bottom:1rem;">
                <label style="display:block; margin-bottom:.4rem; font-weight:600;">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       style="width:100%; padding:.75rem 1rem; background:#1a1a1a; border:1px solid #333; color:#fff; border-radius:6px;">
            </div>

            <div style="margin-bottom:1.5rem;">
                <label style="display:block; margin-bottom:.4rem; font-weight:600;">Password</label>
                <input type="password" name="password" required
                       style="width:100%; padding:.75rem 1rem; background:#1a1a1a; border:1px solid #333; color:#fff; border-radius:6px;">
            </div>

            <div style="margin-bottom:1.5rem; display:flex; align-items:center; gap:.5rem;">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember me</label>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Log In</button>
        </form>
    </div>
</div>
@endsection
