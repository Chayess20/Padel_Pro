<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_player_can_register(): void
    {
        $response = $this->postJson('/api/register', [
            'full_name' => 'Test Player',
            'email'     => 'test@example.com',
            'password'  => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('users', ['email' => 'test@example.com', 'role' => 'player']);
    }

    public function test_register_requires_unique_email(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);

        $response = $this->postJson('/api/register', [
            'full_name' => 'Another Player',
            'email'     => 'taken@example.com',
            'password'  => 'password123',
        ]);

        $response->assertStatus(422);
    }

    public function test_register_requires_minimum_password_length(): void
    {
        $response = $this->postJson('/api/register', [
            'full_name' => 'Test Player',
            'email'     => 'test@example.com',
            'password'  => 'short',
        ]);

        $response->assertStatus(422);
    }

    public function test_player_can_login(): void
    {
        User::factory()->create([
            'email'    => 'player@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email'    => 'player@example.com',
            'password' => 'secret123',
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        User::factory()->create([
            'email'    => 'player@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email'    => 'player@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson(['success' => false]);
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_session_returns_user_data_when_authenticated(): void
    {
        $user = User::factory()->create(['role' => 'player']);

        $response = $this->actingAs($user)->getJson('/api/session');

        $response->assertStatus(200)
            ->assertJson(['success' => true, 'data' => ['role' => 'player']]);
    }

    public function test_session_returns_failure_when_unauthenticated(): void
    {
        $response = $this->getJson('/api/session');

        $response->assertJson(['success' => false]);
    }
}
