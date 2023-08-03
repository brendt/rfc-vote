<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Rfc extends Model
{
    use HasFactory;

    protected $casts = [
        'published_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();

        // When a RFC model is saved, we set its slug from the title
        static::saving(function (Rfc $rfc) {
            $rfc->slug = Str::slug($rfc->title);
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

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
