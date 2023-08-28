<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Argument
 *
 * @property int $id
 * @property int $user_id
 * @property int $rfc_id
 * @property \App\Models\VoteType $vote_type
 * @property string $body
 * @property int $vote_count
 * @property \Illuminate\Support\Carbon|null $body_updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Rfc $rfc
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ArgumentVote> $votes
 * @property-read int|null $votes_count
 * @method static \Database\Factories\ArgumentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Argument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Argument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Argument query()
 * @method static \Illuminate\Database\Eloquent\Builder|Argument whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Argument whereBodyUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Argument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Argument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Argument whereRfcId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Argument whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Argument whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Argument whereVoteCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Argument whereVoteType($value)
 * @mixin \Eloquent
 */
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
