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

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string|null $avatar
 * @property string|null $website_url
 * @property string|null $github_url
 * @property string|null $twitter_url
 * @property int $reputation
 * @property int $is_admin
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property string|null $socialite
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $email_optin
 * @property \App\Models\UserFlair $flair
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserArgumentView> $argumentViews
 * @property-read int|null $argument_views_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ArgumentVote> $argumentVotes
 * @property-read int|null $argument_votes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Argument> $arguments
 * @property-read int|null $arguments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmailChangeRequest> $emailChangeRequests
 * @property-read int|null $email_change_requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserMail> $mails
 * @property-read int|null $mails_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VerificationRequest> $pendingVerificationRequests
 * @property-read int|null $pending_verification_requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VerificationRequest> $verificationRequests
 * @property-read int|null $verification_requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Argument> $viewedArguments
 * @property-read int|null $viewed_arguments_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailOptin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGithubUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereReputation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSocialite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwitterUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereWebsiteUrl($value)
 * @mixin \Eloquent
 */
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
        'flair' => UserFlair::class,
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

    public function verificationRequests(): HasMany
    {
        return $this->hasMany(VerificationRequest::class);
    }

    public function pendingVerificationRequests(): HasMany
    {
        return $this->hasMany(VerificationRequest::class)->where('status', VerificationRequestStatus::PENDING);
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
        return $this->argumentVotes->first(
            fn (ArgumentVote $argumentVote) => $argumentVote->argument_id === $argument->id
        );
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
}
