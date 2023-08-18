<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'reputation',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'reputation' => 'int',
        'email_optin' => 'bool',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function mails(): HasMany
    {
        return $this->hasMany(UserMail::class);
    }

    public function viewedArguments(): BelongsToMany
    {
        return $this
            ->belongsToMany(Argument::class, 'user_argument_views')
            ->withTimestamps();
    }

    public function argumentViews(): HasMany
    {
        return $this->hasMany(UserArgumentView::class);
    }

    public function argumentVotes(): HasMany
    {
        return $this->hasMany(ArgumentVote::class);
    }

    public function arguments(): HasMany
    {
        return $this->hasMany(Argument::class);
    }

    public function emailChangeRequests(): HasMany
    {
        return $this->hasMany(EmailChangeRequest::class);
    }

    public function getArgumentForRfc(Rfc $rfc): ?Argument
    {
        return $this->arguments->first(fn (Argument $argument) => $argument->rfc_id === $rfc->id);
    }

    public function hasVotedForArgument(Argument $argument): bool
    {
        return $this->getArgumentVoteForArgument($argument) !== null;
    }

    public function getArgumentVoteForArgument(Argument $argument): ?ArgumentVote
    {
        return $this->argumentVotes->first(fn (ArgumentVote $argumentVote) => $argumentVote->argument_id === $argument->id);
    }

    /**
     * @param  \App\Models\Rfc  $rfc
     * @return \Illuminate\Support\Collection<\App\Models\ArgumentVote>
     */
    public function getArgumentVotesForRfc(Rfc $rfc): Collection
    {
        return $this->argumentVotes
            ->reject(fn (ArgumentVote $vote) => $vote->argument->user_id === $this->id)
            ->filter(fn (ArgumentVote $vote) => $vote->argument->rfc_id === $rfc->id);
    }

    public function getAvatarUrl(): ?string
    {
        if (! $this->avatar) {
            $hash = md5(strtolower(trim($this->email)));

            return "https://www.gravatar.com/avatar/{$hash}";
        }

        return url($this->avatar);
    }

    public function getVotesPerRfc(): int
    {
        return match (true) {
            $this->reputation >= 10_000 => 6,
            $this->reputation >= 5000 => 5,
            $this->reputation >= 1000 => 4,
            default => 3,
        };
    }

    public function getAvailableVotesForRfc(Rfc $rfc): int
    {
        return $this->getVotesPerRfc() - $this->getArgumentVotesForRfc($rfc)->count();
    }

    public function hasSeenArgument(Argument $argument): bool
    {
        $argumentView = $this->argumentViews
            ->first(fn (UserArgumentView $userArgumentView) => $userArgumentView->argument_id === $argument->id);

        if ($argumentView === null) {
            return false;
        }

        return now()->diffInMinutes($argumentView->created_at) > 5;
    }

    public function shouldSeeTutorial(): bool
    {
        if ($this->arguments->count() > 3) {
            return false;
        }

        if ($this->argumentVotes->count() > 10) {
            return false;
        }

        return true;
    }

    public function hasGottenMail(Mailable $mailable): bool
    {
        return $this->mails()->where('mail_type', $mailable::class)->exists();
    }

    public function hasVotedForRfc(Rfc $rfc): bool
    {
        return $this->getArgumentForRfc($rfc)?->exists() ?: false;
    }
}
