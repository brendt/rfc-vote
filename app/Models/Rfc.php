<?php

namespace App\Models;

use App\Actions\SendNewRfcMails;
use App\Http\Controllers\RfcDetailController;
use App\Jobs\RenderMetaImageJob;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

/**
 * App\Models\Rfc
 *
 * @property int $id
 * @property string $title
 * @property string|null $teaser
 * @property string $slug
 * @property string|null $url
 * @property string|null $description
 * @property int $count_yes
 * @property int $count_no
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $ends_at
 * @property mixed|null $meta_image
 * @property-read Collection<int, \App\Models\Argument> $arguments
 * @property-read int|null $arguments_count
 * @property-read Collection<int, \App\Models\Argument> $noArguments
 * @property-read int|null $no_arguments_count
 * @property-read Collection<int, \App\Models\Argument> $yesArguments
 * @property-read int|null $yes_arguments_count
 * @method static \Database\Factories\RfcFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Rfc newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rfc newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rfc query()
 * @method static \Illuminate\Database\Eloquent\Builder|Rfc whereCountNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rfc whereCountYes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rfc whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rfc whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rfc whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rfc whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rfc whereMetaImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rfc wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rfc whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rfc whereTeaser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rfc whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rfc whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rfc whereUrl($value)
 * @mixin \Eloquent
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

    public function arguments(): HasMany
    {
        return $this->hasMany(Argument::class)->orderByDesc('vote_count')->orderByDesc('created_at');
    }

    public function userArgument(User $user)
    {
        return $this->arguments->first(fn (Argument $argument) => $argument->user_id === $user->id);
    }

    public function hasRfcVotedByUser(User $user): bool
    {
        return $this->userArgument($user)?->exists() ?: false;
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
                if ($this->countTotal() === 0) {
                    return 0;
                }

                return round(($this->count_yes / ($this->count_yes + $this->count_no)) * 100);
            },
        );
    }

    public function percentageNo(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->count_no === 0) {
                    return 0;
                }

                return round(($this->count_no / ($this->count_no + $this->count_no)) * 100);
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
        return $this->percentageYes() >= 50;
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
            ->id($this->id)
            ->title($this->title)
            ->summary($this->teaser)
            ->updated($this->updated_at)
            ->link(action(RfcDetailController::class, $this))
            ->authorName('Brent')
            ->authorEmail('brendt@stitcher.io');
    }
}
