@extends('layouts.app')

@section('title', 'My Profile — PADEL ACE')

@section('content')
<div class="page-layout-wrapper">
    <section class="section">
        <h1 class="section-title">My Profile</h1>

        <div class="profile-card">
            <h2>{{ $user->name }}</h2>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Division:</strong> {{ $user->division }}</p>
            <p><strong>Points:</strong> {{ $user->points }}P</p>
            <p><strong>Tournaments Entered:</strong> {{ $user->registrations_count }}</p>

            @if($nextDivision)
                <p><strong>Next Division:</strong> {{ $nextDivision }} ({{ $nextPoints }}P needed)</p>
            @endif
        </div>

        @if($upcomingTournaments->isNotEmpty())
        <h3>Upcoming Tournaments</h3>
        <table class="ranking-table">
            <thead>
                <tr><th>Tournament</th><th>Division</th><th>Date</th><th>Fee</th></tr>
            </thead>
            <tbody>
                @foreach($upcomingTournaments as $reg)
                <tr>
                    <td>{{ $reg->tournament->title }}</td>
                    <td>{{ $reg->tournament->division }}</td>
                    <td>{{ $reg->tournament->event_date?->format('M d, Y') ?? 'TBA' }}</td>
                    <td>&euro;{{ number_format($reg->tournament->entry_fee, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </section>
</div>
@endsection