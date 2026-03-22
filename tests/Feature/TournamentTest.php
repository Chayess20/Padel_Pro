<?php

namespace Tests\Feature;

use App\Models\Tournament;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TournamentTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_open_tournaments(): void
    {
        Tournament::factory()->create(['status' => 'open']);
        Tournament::factory()->create(['status' => 'completed']);

        $response = $this->getJson('/api/tournaments');

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertCount(1, $response->json('data'));
    }

    public function test_tournament_list_can_be_filtered_by_division(): void
    {
        Tournament::factory()->create(['status' => 'open', 'division' => 'Advanced']);
        Tournament::factory()->create(['status' => 'open', 'division' => 'Beginner']);

        $response = $this->getJson('/api/tournaments?division=Advanced');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
        $this->assertEquals('Advanced', $response->json('data.0.division'));
    }

    public function test_authenticated_player_can_register_for_tournament(): void
    {
        $user       = User::factory()->create();
        $tournament = Tournament::factory()->create(['max_players' => 10, 'status' => 'open']);

        $response = $this->actingAs($user)->postJson('/api/tournaments/register', [
            'tournament_id' => $tournament->id,
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('tournament_registrations', [
            'user_id'       => $user->id,
            'tournament_id' => $tournament->id,
        ]);
    }

    public function test_player_cannot_register_twice_for_same_tournament(): void
    {
        $user       = User::factory()->create();
        $tournament = Tournament::factory()->create(['max_players' => 10]);

        $this->actingAs($user)->postJson('/api/tournaments/register', [
            'tournament_id' => $tournament->id,
        ]);

        $response = $this->actingAs($user)->postJson('/api/tournaments/register', [
            'tournament_id' => $tournament->id,
        ]);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_player_cannot_register_when_tournament_is_full(): void
    {
        $user       = User::factory()->create();
        $tournament = Tournament::factory()->create(['max_players' => 1]);

        $otherUser = User::factory()->create();
        $this->actingAs($otherUser)->postJson('/api/tournaments/register', [
            'tournament_id' => $tournament->id,
        ]);

        $response = $this->actingAs($user)->postJson('/api/tournaments/register', [
            'tournament_id' => $tournament->id,
        ]);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
    }

    public function test_unauthenticated_user_cannot_register_for_tournament(): void
    {
        $tournament = Tournament::factory()->create(['max_players' => 10]);

        $response = $this->postJson('/api/tournaments/register', [
            'tournament_id' => $tournament->id,
        ]);

        $response->assertStatus(401);
    }
}
