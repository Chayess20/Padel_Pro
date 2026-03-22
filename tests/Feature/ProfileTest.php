<?php

namespace Tests\Feature;

use App\Models\Tournament;
use App\Models\TournamentRegistration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_player_can_view_profile(): void
    {
        $user = User::factory()->create(['role' => 'player', 'points' => 0, 'division' => 'Beginner']);

        $response = $this->actingAs($user)->getJson('/api/profile');

        $response->assertStatus(200)
            ->assertJson(['success' => true, 'data' => ['full_name' => $user->name]]);
    }

    public function test_unauthenticated_user_cannot_view_profile(): void
    {
        $response = $this->getJson('/api/profile');

        $response->assertStatus(401);
    }

    public function test_player_can_update_phone(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/update-profile', [
            'phone' => '+49123456789',
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('users', ['id' => $user->id, 'phone' => '+49123456789']);
    }

    public function test_player_can_change_password(): void
    {
        $user = User::factory()->create(['password' => bcrypt('oldpassword')]);

        $response = $this->actingAs($user)->postJson('/api/update-profile', [
            'current_password' => 'oldpassword',
            'new_password'     => 'newpassword1',
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_wrong_current_password_is_rejected(): void
    {
        $user = User::factory()->create(['password' => bcrypt('realpassword')]);

        $response = $this->actingAs($user)->postJson('/api/update-profile', [
            'current_password' => 'wrongpassword',
            'new_password'     => 'newpassword1',
        ]);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_player_can_cancel_upcoming_booking(): void
    {
        $user       = User::factory()->create();
        $tournament = Tournament::factory()->create([
            'event_date' => now()->addDays(7)->toDateString(),
        ]);

        $registration = TournamentRegistration::create([
            'user_id'       => $user->id,
            'tournament_id' => $tournament->id,
        ]);

        $response = $this->actingAs($user)->postJson('/api/cancel-booking', [
            'booking_id' => $registration->id,
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseMissing('tournament_registrations', ['id' => $registration->id]);
    }

    public function test_player_cannot_cancel_past_booking(): void
    {
        $user       = User::factory()->create();
        $tournament = Tournament::factory()->create([
            'event_date' => now()->subDays(1)->toDateString(),
        ]);

        $registration = TournamentRegistration::create([
            'user_id'       => $user->id,
            'tournament_id' => $tournament->id,
        ]);

        $response = $this->actingAs($user)->postJson('/api/cancel-booking', [
            'booking_id' => $registration->id,
        ]);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_player_cannot_cancel_another_players_booking(): void
    {
        $user       = User::factory()->create();
        $otherUser  = User::factory()->create();
        $tournament = Tournament::factory()->create([
            'event_date' => now()->addDays(7)->toDateString(),
        ]);

        $registration = TournamentRegistration::create([
            'user_id'       => $otherUser->id,
            'tournament_id' => $tournament->id,
        ]);

        $response = $this->actingAs($user)->postJson('/api/cancel-booking', [
            'booking_id' => $registration->id,
        ]);

        $response->assertStatus(404)
            ->assertJson(['success' => false]);
    }

    public function test_profile_next_points_is_null_at_max_division(): void
    {
        $user = User::factory()->create([
            'role'     => 'player',
            'division' => 'Professional',
            'points'   => 3500,
        ]);

        $response = $this->actingAs($user)->getJson('/api/profile');

        $response->assertStatus(200);
        $this->assertNull($response->json('data.next_points'));
    }
}
