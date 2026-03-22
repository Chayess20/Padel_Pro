<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tournament>
 */
class TournamentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'           => fake()->words(3, true),
            'type'            => fake()->randomElement(['monthly', 'weekly']),
            'category'        => fake()->optional()->word(),
            'division'        => fake()->randomElement(['Beginner', 'Intermediate', 'Advanced', 'Professional']),
            'required_points' => 0,
            'win_points'      => fake()->numberBetween(10, 100),
            'final_points'    => fake()->numberBetween(5, 50),
            'semi_points'     => fake()->numberBetween(2, 25),
            'quarter_points'  => fake()->numberBetween(1, 10),
            'entry_fee'       => fake()->randomFloat(2, 0, 50),
            'max_players'     => fake()->randomElement([8, 16, 32]),
            'status'          => 'open',
            'event_date'      => fake()->dateTimeBetween('now', '+6 months')->format('Y-m-d'),
        ];
    }
}
