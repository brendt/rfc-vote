<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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

    public function arguments(): HasMany
    {
        return $this->hasMany(Argument::class);
    }

    public function argumentVotes(): HasMany
    {
        return $this->hasMany(UserArgumentVote::class);
    }

    public function getArgumentFor(Vote $vote): ?Argument
    {
        return $this->arguments->first(
            fn (Argument $argument) => $argument->vote_id === $vote->id,
        );
    }

    public function hasArgumentFor(Vote $vote): bool
    {
        return $this->getArgumentFor($vote) !== null;
    }

    public function hasVotedForArgument(Argument $argument): bool
    {
        return $this->getArgumentVoteFor($argument) !== null;
    }

    public function getArgumentVoteFor(Argument $argument): ?UserArgumentVote
    {
        return $this->argumentVotes->first(
            fn (UserArgumentVote $userArgumentVote) => $userArgumentVote->argument_id === $argument->id,
        );
    }

    public function addArgumentVote(Argument $argument): UserArgumentVote
    {
        $userArgumentVote = UserArgumentVote::create([
            'user_id' => $this->id,
            'argument_id' => $argument->id,
        ]);

        $argument->update([
            'vote_count' => $argument->vote_count + 1,
        ]);

        return $userArgumentVote;
    }

    public function removeArgumentVote(Argument $argument): void
    {
        $userArgumentVote = $this->getArgumentVoteFor($argument);

        if (! $userArgumentVote) {
            return;
        }

        $userArgumentVote->delete();

        $argument->update([
            'vote_count' => $argument->vote_count - 1,
        ]);
    }
}
