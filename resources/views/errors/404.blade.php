@extends('layouts.app')

@section('title', '404 — Page Not Found')

@section('content')
<div style="min-height:100vh; display:flex; flex-direction:column; align-items:center; justify-content:center;
            padding: 2rem; text-align:center; background:var(--navy); color:var(--white);">
    <p style="font-family:var(--font-display); font-size:8rem; line-height:1; color:var(--neon-yellow); margin:0;">404</p>
    <h1 style="font-family:var(--font-heading); font-size:2rem; margin:1rem 0 0.5rem;">Page Not Found</h1>
    <p style="color:rgba(255,255,255,0.6); max-width:420px; margin-bottom:2rem;">
        The page you are looking for doesn't exist or has been moved.
    </p>
    <a href="{{ url('/') }}" class="btn btn-primary">Back to Home</a>
</div>
@endsection
