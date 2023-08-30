<?php

namespace App\Models;

use App\Actions\SendNewRfcMails;
use App\Http\Controllers\RfcDetailController;
use App\Jobs\RenderMetaImageJob;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

/**
 * @property ?string $meta_image
 * @property CarbonInterface $updated_at
 */
class Rfc extends Model implements Feedable
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

            (new SendNewRfcMails)($rfc);
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

    /**
     * @return HasMany<Argument>
     */
    public function arguments(): HasMany
    {
        return $this->hasMany(Argument::class)->orderByDesc('vote_count')->orderByDesc('created_at');
    }

    public function userArgument(User $user): ?Argument
    {
        return $this->arguments->first(fn (Argument $argument) => $argument->user_id === $user->id);
    }

    public function hasRfcVotedByUser(User $user): bool
    {
        return $this->userArgument($user)?->exists() ?: false;
    }

    /**
     * @return HasMany<Argument>
     */
    public function yesArguments(): HasMany
    {
        return $this->hasMany(Argument::class)->where('vote_type', VoteType::YES);
    }

    /**
     * @return HasMany<Argument>
     */
    public function noArguments(): HasMany
    {
        return $this->hasMany(Argument::class)->where('vote_type', VoteType::NO);
    }

    /**
     * @return Attribute<int, never>
     */
    protected function countTotal(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->count_yes + $this->count_no,
        );
    }

    /**
     * @return Attribute<int, never>
     */
    protected function percentageYes(): Attribute
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

    /**
     * @return Attribute<int, never>
     */
    protected function percentageNo(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->count_no === 0) {
                    return 0;
                }

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

    /**
     * @return Collection<int, self>
     */
    public static function getFeedItems(): Collection
    {
        return self::query()
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->get();
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id((string) $this->id)
            ->title($this->title)
            ->summary((string) $this->teaser)
            ->updated($this->updated_at)
            ->link(action(RfcDetailController::class, $this))
            ->authorName('Brent')
            ->authorEmail('brendt@stitcher.io');
    }
}
