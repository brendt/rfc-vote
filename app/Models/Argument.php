<?php

namespace App\Models;

use App\Models\Enums\VoteType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Argument extends Model
{
    use HasFactory;

    protected $casts = [
        'body_updated_at' => 'datetime',
        'vote_type' => VoteType::class,
    ];

    public function rfc(): BelongsTo
    {
        return $this->belongsTo(Rfc::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(ArgumentVote::class);
    }
}
