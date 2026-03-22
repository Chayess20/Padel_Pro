<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PlayerSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@padelace.de'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('admin1234'),
                'role'     => 'admin',
                'division' => 'Professional',
                'points'   => 0,
            ]
        );

        // Demo players
        $players = [
            ['name' => 'Lukas Becker',    'email' => 'lukas@example.de',  'gender' => 'male',   'points' => 3850, 'division' => 'Professional'],
            ['name' => 'Marco Fischer',   'email' => 'marco@example.de',  'gender' => 'male',   'points' => 3120, 'division' => 'Professional'],
            ['name' => 'Jonas Müller',    'email' => 'jonas@example.de',  'gender' => 'male',   'points' => 1800, 'division' => 'Advanced'],
            ['name' => 'Felix Wagner',    'email' => 'felix@example.de',  'gender' => 'male',   'points' => 1350, 'division' => 'Advanced'],
            ['name' => 'Tim Schneider',   'email' => 'tim@example.de',    'gender' => 'male',   'points' => 650,  'division' => 'Intermediate'],
            ['name' => 'Leon Braun',      'email' => 'leon@example.de',   'gender' => 'male',   'points' => 420,  'division' => 'Intermediate'],
            ['name' => 'Nico Weber',      'email' => 'nico@example.de',   'gender' => 'male',   'points' => 180,  'division' => 'Beginner'],
            ['name' => 'Anna Schmidt',    'email' => 'anna@example.de',   'gender' => 'female', 'points' => 2900, 'division' => 'Professional'],
            ['name' => 'Laura Hoffmann',  'email' => 'laura@example.de',  'gender' => 'female', 'points' => 2100, 'division' => 'Professional'],
            ['name' => 'Sophie Klein',    'email' => 'sophie@example.de', 'gender' => 'female', 'points' => 1400, 'division' => 'Advanced'],
            ['name' => 'Mia Richter',     'email' => 'mia@example.de',    'gender' => 'female', 'points' => 750,  'division' => 'Intermediate'],
            ['name' => 'Emma Wolf',       'email' => 'emma@example.de',   'gender' => 'female', 'points' => 310,  'division' => 'Intermediate'],
        ];

        foreach ($players as $data) {
            User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'     => $data['name'],
                    'password' => Hash::make('password'),
                    'role'     => 'player',
                    'gender'   => $data['gender'],
                    'points'   => $data['points'],
                    'division' => $data['division'],
                ]
            );
        }
    }
}
