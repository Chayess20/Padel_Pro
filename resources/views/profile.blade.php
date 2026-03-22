@extends('layouts.app')

@section('title', 'My Profile — PADEL ACE')

@section('content')
<div class="page-layout-wrapper">
    <section class="section">
        <h1 class="section-title">My Profile</h1>

        <div class="profile-card">
            <h2>{{ $user->full_name }}</h2>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Division:</strong> {{ $user->division }}</p>
            <p><strong>Points:</strong> {{ $user->points }}P</p>
            <p><strong>Tournaments Entered:</strong> {{ $user->tournament_registrations_count }}</p>

            @if($nextDivision)
                <p><strong>Next Division:</strong> {{ $nextDivision }} ({{ $nextPoints }}P needed)</p>
            @endif
        </div>

        @if($upcomingTournaments->isNotEmpty())
        <h3>Upcoming Tournaments</h3>
        <table class="ranking-table">
            <thead>
                <tr><th>Tournament</th><th>Division</th><th>Date</th><th>Fee</th><th>Action</th></tr>
            </thead>
            <tbody>
                @foreach($upcomingTournaments as $reg)
                <tr>
                    <td>{{ $reg->tournament->title }}</td>
                    <td>{{ $reg->tournament->division }}</td>
                    <td>{{ $reg->tournament->event_date?->format('M d, Y') ?? 'TBA' }}</td>
                    <td>&euro;{{ number_format($reg->tournament->entry_fee, 2) }}</td>
                    <td>
                        <form method="POST" action="{{ route('bookings.cancel') }}">
                            @csrf
                            <input type="hidden" name="booking_id" value="{{ $reg->id }}">
                            <input type="hidden" name="type" value="tournament">
                            <button type="submit" class="btn btn-outline btn-sm">Cancel</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        @if($upcomingCourts->isNotEmpty())
        <h3>Upcoming Court Bookings</h3>
        <table class="ranking-table">
            <thead>
                <tr><th>Court</th><th>Date</th><th>Time</th><th>Paid</th><th>Action</th></tr>
            </thead>
            <tbody>
                @foreach($upcomingCourts as $booking)
                <tr>
                    <td>{{ $booking->court->name }}</td>
                    <td>{{ $booking->booking_date->format('M d, Y') }}</td>
                    <td>{{ $booking->time_slot }}</td>
                    <td>&euro;{{ number_format($booking->amount_paid, 2) }}</td>
                    <td>
                        <form method="POST" action="{{ route('bookings.cancel') }}">
                            @csrf
                            <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                            <input type="hidden" name="type" value="court">
                            <button type="submit" class="btn btn-outline btn-sm">Cancel</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </section>
</div>
@endsection