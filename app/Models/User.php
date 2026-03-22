<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'gender',
        'national_ranking',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'national_ranking' => 'boolean', 
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Determine the division name for a given point total.
     * Single source of truth used by controllers and tests.
     */
    public static function divisionForPoints(int $points): string
    {
        if ($points >= 3000) return 'Professional';
        if ($points >= 1000) return 'Advanced';
        if ($points >= 300)  return 'Intermediate';
        return 'Beginner';
    }

    public function rankingAdjustments()
    {
        return $this->hasMany(RankingAdjustment::class);
    }

    public function registrations()
    {
        return $this->hasMany(TournamentRegistration::class);
    }
}