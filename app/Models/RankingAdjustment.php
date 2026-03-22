<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RankingAdjustment extends Model
{
   protected $fillable = [
    'user_id', 'tournament_id', 'points_before', 
    'amount', 'points_after', 'placement', 'reason'
];
public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }
}
