<?php

namespace App\Models;

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

    /**
     * @return BelongsTo<Rfc, self>
     */
    public function rfc(): BelongsTo
    {
        return $this->belongsTo(Rfc::class);
    }

    /**
     * @return BelongsTo<User, self>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<ArgumentVote>
     */
    public function votes(): HasMany
    {
        return $this->hasMany(ArgumentVote::class);
    }

    /**
     * @return HasMany<ArgumentComment>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(ArgumentComment::class);
    }
}
