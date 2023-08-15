<?php

namespace App\Models;

use App\Jobs\RenderMetaImageJob;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Rfc extends Model
{
    use HasFactory;

    protected $casts = [
        'published_at' => 'datetime:Y-m-d',
        'ends_at' => 'datetime:Y-m-d',
        'meta_image_valid_until' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::created(function (Rfc $rfc) {
            $rfc->updateVoteCount();
        });

        static::saving(function (Rfc $rfc) {
            if ($rfc->slug !== null) {
                return;
            }

            $slug = Str::slug($rfc->title);

            $slugCount = self::query()->where('slug', 'like', "{$slug}%")->count();

            $rfc->slug = $slugCount === 0 ? $slug : "{$slug}-{$slugCount}";

            $rfc->save();
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

    public function yesArguments(): HasMany
    {
        return $this->hasMany(Argument::class)->where('vote_type', VoteType::YES);
    }

    public function noArguments(): HasMany
    {
        return $this->hasMany(Argument::class)->where('vote_type', VoteType::NO);
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
                return 100 - $this->percentage_yes;
            },
        );
    }

    public function isActive(): bool
    {
        if ($this->ends_at && $this->ends_at->lt(now())) {
            return false;
        }

        return $this->published_at && $this->published_at->lte(now());
    }

    public function majorityYes(): bool
    {
        return $this->percentage_yes >= 50;
    }

    public function majorityNo(): bool
    {
        return $this->percentage_no > 50;
    }

    public function updateVoteCount(): void
    {
        $this->update([
            'count_yes' => $this->yesArguments()->sum('vote_count'),
            'count_no' => $this->noArguments()->sum('vote_count'),
        ]);

        dispatch(new RenderMetaImageJob($this));
    }
}
