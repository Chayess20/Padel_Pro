<?php

namespace App\Models;

use App\Models\TournamentRegistration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tournament extends Model
{
   protected $fillable = [
    'title', 
    'type',        
    'category',    
    'division',    
    'win_points', 
    'final_points', 
    'semi_points', 
    'quarter_points', 
    'required_points', 
    'status',     
    'event_date',
    'entry_fee',   
    'max_players'  
];

    protected $casts = [
        'event_date' => 'date',
    ];

    public function registrations(): HasMany
{
    return $this->hasMany(TournamentRegistration::class);
}
}