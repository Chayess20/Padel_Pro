<?php

namespace App\Http\Controllers;

use App\Models\TournamentRegistration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Return the authenticated player's profile data.
     */
    public function show(): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $registrations = TournamentRegistration::with('tournament')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $recentTournaments = $registrations->take(5)->map(function ($reg) {
            $t = $reg->tournament;
            return [
                'title'    => $t->title ?? 'Tournament',
                'division' => $t->division ?? '',
                'category' => $t->category ?? '',
            ];
        })->values()->toArray();

        $upcomingTournaments = $registrations
            ->filter(function ($reg) {
                $t = $reg->tournament;
                return $t && $t->event_date && $t->event_date >= now()->toDateString();
            })
            ->take(10)
            ->map(function ($reg) {
                $t = $reg->tournament;
                return [
                    'id'         => $reg->id,
                    'title'      => $t->title ?? 'Tournament',
                    'division'   => $t->division ?? '',
                    'event_date' => $t->event_date ?? null,
                    'entry_fee'  => $t->entry_fee ?? 0,
                ];
            })->values()->toArray();

        // Division progression — must match User::divisionForPoints() thresholds
        $divisions    = ['Beginner', 'Intermediate', 'Advanced', 'Professional'];
        $thresholds   = [0, 300, 1000, 3000];
        $currentIndex = array_search($user->division, $divisions);
        $currentIndex = $currentIndex === false ? 0 : $currentIndex;

        $isMaxDivision = $currentIndex === count($divisions) - 1;
        $nextDivision  = $isMaxDivision ? $divisions[$currentIndex] : $divisions[$currentIndex + 1];
        $nextPoints    = $isMaxDivision ? null : $thresholds[$currentIndex + 1];

        return response()->json([
            'success' => true,
            'data'    => [
                'full_name'           => $user->name,
                'email'               => $user->email,
                'phone'               => $user->phone,
                'division'            => $user->division,
                'points'              => $user->points,
                'tournament_count'    => $registrations->count(),
                'next_division'       => $nextDivision,
                'next_points'         => $nextPoints,
                'recent_tournaments'  => $recentTournaments,
                'upcoming_tournaments'=> $upcomingTournaments,
            ],
        ]);
    }

    /**
     * Cancel an upcoming tournament registration.
     */
    public function cancelBooking(Request $request): JsonResponse
    {
        $request->validate(['booking_id' => ['required', 'integer']]);

        $registration = TournamentRegistration::where('id', $request->booking_id)
            ->where('user_id', Auth::id())
            ->first();

        if (! $registration) {
            return response()->json(['success' => false, 'message' => 'Booking not found.'], 404);
        }

        $tournament = $registration->tournament;
        if ($tournament && $tournament->event_date && $tournament->event_date < now()->toDateString()) {
            return response()->json(['success' => false, 'message' => 'Cannot cancel a past tournament.'], 422);
        }

        $registration->delete();

        return response()->json(['success' => true, 'message' => 'Booking cancelled successfully.']);
    }

    /**
     * Update the authenticated player's phone and/or password.
     */
    public function update(Request $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'phone'            => ['nullable', 'string', 'max:30'],
            'current_password' => ['nullable', 'string'],
            'new_password'     => ['nullable', Password::min(8)],
        ]);

        if (! empty($validated['new_password'])) {
            if (empty($validated['current_password']) || ! Hash::check($validated['current_password'], $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect.',
                ], 422);
            }
            $user->password = Hash::make($validated['new_password']);
        }

        if (isset($validated['phone'])) {
            $user->phone = $validated['phone'];
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.',
        ]);
    }
}
