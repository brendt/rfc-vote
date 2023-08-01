<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rfc extends Model
{
    use HasFactory;

    public function arguments(): HasMany
    {
        return $this->hasMany(Argument::class)->orderByDesc('vote_count')->orderByDesc('created_at');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function yesVotes(): HasMany
    {
        return $this->hasMany(Vote::class)->where('type', VoteType::YES);
    }

    public function noVotes(): HasMany
    {
        return $this->hasMany(Vote::class)->where('type', VoteType::NO);
    }

    public function countTotal(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->count_yes + $this->count_no,
        );
    }

    public function percentageYes(): Attribute
    {

        return Attribute::make(
            get: function () {
                if ($this->count_total === 0) {
                    return 0;
                }

                return round(($this->count_yes / $this->count_total) * 100);
            },
        );
    }

    public function percentageNo(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->count_total === 0) {
                    return 0;
                }

                return round(($this->count_no / $this->count_total) * 100);
            },
        );
    }

    public function getVoteForUser(User $user): ?Vote
    {
        return $this->votes->first(fn (Vote $vote) => $vote->user_id === $user->id);
    }
}
