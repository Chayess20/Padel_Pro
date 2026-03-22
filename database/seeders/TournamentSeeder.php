<?php

namespace Database\Seeders;

use App\Models\Tournament;
use Illuminate\Database\Seeder;

class TournamentSeeder extends Seeder
{
    public function run(): void
    {
        // Monthly DPT tournaments
        $monthly = [
            [
                'title'           => 'DPT Gold Tour — Hamburg',
                'type'            => 'monthly',
                'category'        => 'Gold Tour',
                'division'        => 'Professional',
                'required_points' => 3000,
                'win_points'      => 2000,
                'final_points'    => 0,
                'semi_points'     => 1000,
                'quarter_points'  => 600,
                'entry_fee'       => 0,
                'max_players'     => 32,
                'status'          => 'open',
                'event_date'      => now()->addDays(20)->toDateString(),
            ],
            [
                'title'           => 'DPT Gold Tour — Berlin',
                'type'            => 'monthly',
                'category'        => 'Gold Tour',
                'division'        => 'Advanced',
                'required_points' => 1000,
                'win_points'      => 1000,
                'final_points'    => 750,
                'semi_points'     => 500,
                'quarter_points'  => 300,
                'entry_fee'       => 0,
                'max_players'     => 32,
                'status'          => 'open',
                'event_date'      => now()->addDays(27)->toDateString(),
            ],
            [
                'title'           => 'DPT Silver Tour — Düsseldorf',
                'type'            => 'monthly',
                'category'        => 'Silver Tour',
                'division'        => 'Intermediate',
                'required_points' => 300,
                'win_points'      => 500,
                'final_points'    => 300,
                'semi_points'     => 200,
                'quarter_points'  => 100,
                'entry_fee'       => 0,
                'max_players'     => 32,
                'status'          => 'open',
                'event_date'      => now()->addDays(34)->toDateString(),
            ],
            [
                'title'           => 'DPT Silver Tour — Munich',
                'type'            => 'monthly',
                'category'        => 'Silver Tour',
                'division'        => 'Beginner',
                'required_points' => 0,
                'win_points'      => 300,
                'final_points'    => 200,
                'semi_points'     => 100,
                'quarter_points'  => 0,
                'entry_fee'       => 0,
                'max_players'     => 32,
                'status'          => 'open',
                'event_date'      => now()->addDays(41)->toDateString(),
            ],
            [
                'title'           => 'DPT Gold Tour — Women',
                'type'            => 'monthly',
                'category'        => 'Gold Tour',
                'division'        => 'Women',
                'required_points' => 0,
                'win_points'      => 1000,
                'final_points'    => 750,
                'semi_points'     => 500,
                'quarter_points'  => 300,
                'entry_fee'       => 0,
                'max_players'     => 32,
                'status'          => 'open',
                'event_date'      => now()->addDays(48)->toDateString(),
            ],
        ];

        foreach ($monthly as $data) {
            Tournament::create($data);
        }

        // Weekly tournaments
        $weekly = [
            [
                'title'           => 'Weekly Intermediate Cup',
                'type'            => 'weekly',
                'category'        => 'Weekly',
                'division'        => 'Intermediate',
                'required_points' => 0,
                'win_points'      => 100,
                'final_points'    => 0,
                'semi_points'     => 50,
                'quarter_points'  => 0,
                'entry_fee'       => 15.50,
                'max_players'     => 16,
                'status'          => 'open',
                'event_date'      => now()->addDays(5)->toDateString(),
            ],
            [
                'title'           => 'Weekly Advanced Challenge',
                'type'            => 'weekly',
                'category'        => 'Weekly',
                'division'        => 'Advanced',
                'required_points' => 1000,
                'win_points'      => 200,
                'final_points'    => 0,
                'semi_points'     => 100,
                'quarter_points'  => 0,
                'entry_fee'       => 20.00,
                'max_players'     => 16,
                'status'          => 'open',
                'event_date'      => now()->addDays(5)->toDateString(),
            ],
            [
                'title'           => 'Weekly Beginner Open',
                'type'            => 'weekly',
                'category'        => 'Weekly',
                'division'        => 'Intermediate',
                'required_points' => 0,
                'win_points'      => 80,
                'final_points'    => 0,
                'semi_points'     => 40,
                'quarter_points'  => 0,
                'entry_fee'       => 12.00,
                'max_players'     => 16,
                'status'          => 'open',
                'event_date'      => now()->addDays(12)->toDateString(),
            ],
            [
                'title'           => 'Weekly Advanced Masters',
                'type'            => 'weekly',
                'category'        => 'Weekly',
                'division'        => 'Advanced',
                'required_points' => 1000,
                'win_points'      => 250,
                'final_points'    => 0,
                'semi_points'     => 125,
                'quarter_points'  => 0,
                'entry_fee'       => 25.00,
                'max_players'     => 16,
                'status'          => 'open',
                'event_date'      => now()->addDays(12)->toDateString(),
            ],
        ];

        foreach ($weekly as $data) {
            Tournament::create($data);
        }
    }
}
