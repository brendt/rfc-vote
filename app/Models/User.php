<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
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

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function arguments(): HasMany
    {
        return $this->hasMany(Argument::class);
    }

    public function createVote(Rfc $rfc, VoteType $type): Vote
    {
        return DB::transaction(function () use ($type, $rfc) {
            $vote = $this->getVoteForRfc($rfc);

            if (! $vote) {
                $vote = new Vote([
                    'user_id' => $this->id,
                    'rfc_id' => $rfc->id,
                ]);

                $this->addReputation(ReputationType::VOTE_FOR_RFC);
            }

            $vote->type = $type;

            $vote->save();

            $rfc->update([
                'count_yes' => $rfc->yesVotes()->count(),
                'count_no' => $rfc->noVotes()->count(),
            ]);

            return $vote;
        });
    }

    public function undoVote(Rfc $rfc): void
    {
        DB::transaction(function () use ($rfc) {
            $vote = $this->getVoteForRfc($rfc);
            $vote->delete();
            $this->removeReputation(ReputationType::VOTE_FOR_RFC);

            $rfc->update([
                'count_yes' => $rfc->yesVotes()->count(),
                'count_no' => $rfc->noVotes()->count(),
            ]);
        });
    }

    public function saveArgument(Rfc $rfc, string $body): Argument
    {
        $argument = $this->getArgumentForRfc($rfc);

        if (! $argument) {
            $argument = new Argument([
                'user_id' => $this->id,
                'rfc_id' => $rfc->id,
            ]);

            $this->addReputation(ReputationType::MAKE_ARGUMENT);
            $argument->body = $body;
            $argument->save();
            $this->toggleArgumentVote($argument);
        } else {
            $argument->body_updated_at = now();
            $argument->body = $body;
            $argument->save();
        }

        return $argument;
    }

    public function getVoteForRfc(Rfc $rfc): ?Vote
    {
        return $this->votes->first(fn (Vote $vote) => $vote->rfc_id === $rfc->id);
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

    public function hasAlreadyVotedForArgument(Argument $argument): bool
    {
        return $this
            ->argumentVotes()
            ->withTrashed()
            ->where('argument_id', $argument->id)
            ->exists();
    }

    public function toggleArgumentVote(Argument $argument): void
    {
        DB::transaction(function () use ($argument) {
            $argumentVote = $this->getArgumentVoteForArgument($argument);

            if ($argumentVote) {
                $argumentVote->delete();
                $this->removeReputation(ReputationType::VOTE_FOR_ARGUMENT);
                $argument->user->removeReputation(ReputationType::GAIN_ARGUMENT_VOTE);
            } else {
                $this->addReputation(ReputationType::VOTE_FOR_ARGUMENT);
                $argument->user->addReputation(ReputationType::GAIN_ARGUMENT_VOTE);

                ArgumentVote::create([
                    'argument_id' => $argument->id,
                    'user_id' => $this->id,
                ]);
            }

            $argument->update([
                'vote_count' => $argument->votes()->count(),
            ]);
        });
    }

    public function addReputation(ReputationType $type): self
    {
        $this->increment('reputation', $type->getPoints());

        return $this;
    }

    public function removeReputation(ReputationType $type): self
    {
        $this->decrement('reputation', $type->getPoints());

        return $this;
    }

    public function getAvatarUrl(): ?string
    {
        if (! $this->avatar) {
            return null;
        }

        return url($this->avatar);
    }


    protected function profilePhotoPath(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => isset($value) ? asset($value) : "https://static.vecteezy.com/system/resources/previews/008/442/086/original/illustration-of-human-icon-user-symbol-icon-modern-design-on-blank-background-free-vector.jpg"
        );
    }
}
