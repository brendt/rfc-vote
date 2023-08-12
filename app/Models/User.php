<?php

namespace App\Models;

use App\Mail\EmailVerificationMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
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

    public function undoArgument(Rfc $rfc): void
    {
        DB::transaction(function () use ($rfc) {
            $argument = $this->getArgumentForRfc($rfc);
            $argument->delete();
            $this->removeReputation(ReputationType::CREATE_ARGUMENT);
            $rfc->updateVoteCount();
        });
    }

    public function createArgument(Rfc $rfc, VoteType $voteType, string $body): Argument
    {
        $argument = new Argument([
            'user_id' => $this->id,
            'rfc_id' => $rfc->id,
            'vote_type' => $voteType,
            'body' => $body,
        ]);

        DB::transaction(function () use ($argument) {
            $argument->save();
            $this->addReputation(ReputationType::CREATE_ARGUMENT);
            $this->toggleArgumentVote($argument);
        });

        $rfc->updateVoteCount();

        return $argument;
    }

    public function deleteArgument(Argument $argument): void
    {
        if (! $this->canDeleteArgument($argument)) {
            return;
        }

        DB::transaction(function () use ($argument) {
            $argument->user->decrement('reputation', ReputationType::GAIN_ARGUMENT_VOTE->getPoints() * $argument->votes->count());
            $argument->user->removeReputation(ReputationType::CREATE_ARGUMENT);
            $argument->delete();
            $argument->rfc->updateVoteCount();
        });
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

            $argument->rfc->updateVoteCount();
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
            $hash = md5(strtolower(trim($this->email)));

            return "https://www.gravatar.com/avatar/{$hash}";
        }

        return url($this->avatar);
    }

    public function emailChangeRequest(): HasMany
    {
        return $this->hasMany(EmailChangeRequest::class);
    }

    public function requestEmailChange(string $newEmail): void
    {
        $token = Str::random(64);

        $this->emailChangeRequest()->create([
            'new_email' => $newEmail,
            'token' => $token,
        ]);

        $verificationLink = URL::signedRoute('email.verify', ['token' => $token]);

        Mail::to($newEmail)->send(new EmailVerificationMail($verificationLink));
    }

    public function canDeleteArgument(Argument $argument): bool
    {
        return $this->is_admin || $argument->user_id === $this->id;
    }

    public function canEditArgument(Argument $argument): bool
    {
        return $this->is_admin || $argument->user_id === $this->id;
    }
}
