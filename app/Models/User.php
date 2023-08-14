<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
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
    ];

    protected $appends = [
        'profile_photo_url',
    ];

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
     * @param \App\Models\Rfc $rfc
     * @return \Illuminate\Support\Collection<\App\Models\ArgumentVote>
     */
    public function getArgumentVotesForRfc(Rfc $rfc): Collection
    {
        return $this->argumentVotes
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
        return match(true) {
            default => 3,
            $this->reputation > 1000 => 4,
            $this->reputation > 5000 => 5,
            $this->reputation > 10_000 => 6,
        };
    }

    public function getAvailableVotesForRfc(Rfc $rfc): int
    {
        return $this->getVotesPerRfc() - $this->getArgumentVotesForRfc($rfc)->count();
    }
}
