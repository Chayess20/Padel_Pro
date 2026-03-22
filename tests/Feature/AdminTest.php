<?php

namespace Tests\Feature;

use App\Models\Tournament;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    private function adminUser(): User
    {
        return User::factory()->admin()->create();
    }

    // ── Dashboard ──────────────────────────────────────────────────────────────

    public function test_admin_can_view_dashboard(): void
    {
        $response = $this->actingAs($this->adminUser())->getJson('/api/admin/dashboard');

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_non_admin_cannot_view_dashboard(): void
    {
        $player = User::factory()->create(['role' => 'player']);

        $response = $this->actingAs($player)->getJson('/api/admin/dashboard');

        $response->assertStatus(403);
    }

    public function test_unauthenticated_user_cannot_view_dashboard(): void
    {
        $response = $this->getJson('/api/admin/dashboard');

        $response->assertStatus(401);
    }

    public function test_dashboard_counts_live_tournaments_as_pending_scores(): void
    {
        Tournament::factory()->create(['status' => 'live']);
        Tournament::factory()->create(['status' => 'open']);

        $response = $this->actingAs($this->adminUser())->getJson('/api/admin/dashboard');

        $response->assertStatus(200);
        $this->assertEquals(1, $response->json('data.pendingScores'));
    }

    // ── Players ────────────────────────────────────────────────────────────────

    public function test_admin_can_list_players(): void
    {
        User::factory()->count(3)->create(['role' => 'player']);

        $response = $this->actingAs($this->adminUser())->getJson('/api/admin/players');

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertCount(3, $response->json('data'));
    }

    public function test_admin_players_response_includes_pagination_meta(): void
    {
        $response = $this->actingAs($this->adminUser())->getJson('/api/admin/players');

        $response->assertStatus(200)
            ->assertJsonStructure(['meta' => ['current_page', 'last_page', 'per_page', 'total']]);
    }

    public function test_admin_can_search_players(): void
    {
        User::factory()->create(['name' => 'Alice Smith', 'role' => 'player']);
        User::factory()->create(['name' => 'Bob Jones', 'role' => 'player']);

        $response = $this->actingAs($this->adminUser())->getJson('/api/admin/players?search=Alice');

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
        $this->assertEquals('Alice Smith', $response->json('data.0.full_name'));
    }

    // ── Tournaments ────────────────────────────────────────────────────────────

    public function test_admin_can_create_tournament(): void
    {
        $response = $this->actingAs($this->adminUser())->postJson('/api/admin/tournaments', [
            'title'    => 'Spring Cup',
            'type'     => 'monthly',
            'division' => 'Advanced',
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('tournaments', ['title' => 'Spring Cup']);
    }

    public function test_admin_can_update_tournament(): void
    {
        $tournament = Tournament::factory()->create();

        $response = $this->actingAs($this->adminUser())->postJson('/api/admin/tournaments/update', [
            'id'       => $tournament->id,
            'title'    => 'Updated Title',
            'type'     => $tournament->type,
            'division' => $tournament->division,
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('tournaments', ['id' => $tournament->id, 'title' => 'Updated Title']);
    }

    public function test_admin_can_delete_tournament(): void
    {
        $tournament = Tournament::factory()->create();

        $response = $this->actingAs($this->adminUser())->postJson('/api/admin/tournaments/delete', [
            'id' => $tournament->id,
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseMissing('tournaments', ['id' => $tournament->id]);
    }

    // ── Ranking adjustments ────────────────────────────────────────────────────

    public function test_admin_can_add_points_to_player(): void
    {
        $player = User::factory()->create(['role' => 'player', 'points' => 500]);

        $response = $this->actingAs($this->adminUser())->postJson('/api/admin/adjust-ranking', [
            'user_id' => $player->id,
            'points'  => 200,
            'type'    => 'addition',
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('users', ['id' => $player->id, 'points' => 700]);
    }

    public function test_admin_can_deduct_points_from_player(): void
    {
        $player = User::factory()->create(['role' => 'player', 'points' => 500]);

        $response = $this->actingAs($this->adminUser())->postJson('/api/admin/adjust-ranking', [
            'user_id' => $player->id,
            'points'  => 100,
            'type'    => 'deduction',
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('users', ['id' => $player->id, 'points' => 400]);
    }

    public function test_point_deduction_cannot_go_below_zero(): void
    {
        $player = User::factory()->create(['role' => 'player', 'points' => 100]);

        $response = $this->actingAs($this->adminUser())->postJson('/api/admin/adjust-ranking', [
            'user_id' => $player->id,
            'points'  => 500,
            'type'    => 'deduction',
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('users', ['id' => $player->id, 'points' => 0]);
    }

    public function test_ranking_adjustment_auto_updates_division(): void
    {
        $player = User::factory()->create(['role' => 'player', 'points' => 200, 'division' => 'Beginner']);

        $this->actingAs($this->adminUser())->postJson('/api/admin/adjust-ranking', [
            'user_id' => $player->id,
            'points'  => 200,
            'type'    => 'addition',
        ]);

        $this->assertDatabaseHas('users', ['id' => $player->id, 'points' => 400, 'division' => 'Intermediate']);
    }

    public function test_ranking_adjustment_is_logged(): void
    {
        $player = User::factory()->create(['role' => 'player', 'points' => 500]);

        $this->actingAs($this->adminUser())->postJson('/api/admin/adjust-ranking', [
            'user_id' => $player->id,
            'points'  => 100,
            'type'    => 'addition',
            'reason'  => 'Tournament win',
        ]);

        $this->assertDatabaseHas('ranking_adjustments', [
            'user_id'       => $player->id,
            'amount'        => 100,
            'points_before' => 500,
            'points_after'  => 600,
            'reason'        => 'Tournament win',
        ]);
    }
}
