<?php

namespace App\Models;

use App\Http\Livewire\SortField;
use App\Mail\HasMailId;
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
        'flair' => UserFlair::class,
        'preferred_sort_field' => SortField::class,
    ];

    /**
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function getRouteKeyName(): string
    {
        return 'username';
    }

    /**
     * @return HasMany<UserMail>
     */
    public function mails(): HasMany
    {
        return $this->hasMany(UserMail::class);
    }

    /**
     * @return BelongsToMany<Argument>
     */
    public function viewedArguments(): BelongsToMany
    {
        return $this
            ->belongsToMany(Argument::class, 'user_argument_views')
            ->withTimestamps();
    }

    /**
     * @return HasMany<UserArgumentView>
     */
    public function argumentViews(): HasMany
    {
        return $this->hasMany(UserArgumentView::class);
    }

    /**
     * @return HasMany<ArgumentVote>
     */
    public function argumentVotes(): HasMany
    {
        return $this->hasMany(ArgumentVote::class);
    }

    /**
     * @return HasMany<Argument>
     */
    public function arguments(): HasMany
    {
        return $this->hasMany(Argument::class);
    }

    /**
     * @return HasMany<\App\Models\ArgumentComment>
     */
    public function argumentComments(): HasMany
    {
        return $this->hasMany(ArgumentComment::class);
    }

    /**
     * @return HasMany<EmailChangeRequest>
     */
    public function emailChangeRequests(): HasMany
    {
        return $this->hasMany(EmailChangeRequest::class);
    }

    /**
     * @return HasMany<VerificationRequest>
     */
    public function verificationRequests(): HasMany
    {
        return $this->hasMany(VerificationRequest::class);
    }

    /**
     * @return HasMany<VerificationRequest>
     */
    public function pendingVerificationRequests(): HasMany
    {
        return $this->hasMany(VerificationRequest::class)->where('status', VerificationRequestStatus::PENDING);
    }

    /**
     * @return HasMany<Message>
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)
            ->orderByDesc('created_at');
    }

    /**
     * @return HasMany<Message>
     */
    public function inboxMessages(): HasMany
    {
        return $this->hasMany(Message::class)
            ->whereIn('status', [MessageStatus::UNREAD, MessageStatus::READ])
            ->orderByDesc('created_at')
            ->orderByDesc('id');
    }

    /**
     * @return HasMany<Message>
     */
    public function archivedMessages(): HasMany
    {
        return $this->hasMany(Message::class)
            ->whereIn('status', [MessageStatus::ARCHIVED])
            ->orderByDesc('created_at')
            ->orderByDesc('id');
    }

    /**
     * @return HasMany<Message>
     */
    public function unreadMessages(): HasMany
    {
        return $this->hasMany(Message::class)
            ->where('status', MessageStatus::UNREAD)
            ->orderByDesc('created_at')
            ->orderByDesc('id');
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
     * @return Collection<int, ArgumentVote>
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
        $mailType = $mailable instanceof HasMailId ? $mailable->getMailId() : $mailable::class;

        return $this->mails()->where('mail_type', $mailType)->exists();
    }

    public function updateUnreadMessageCount(): void
    {
        $this->update([
            'unread_message_count' => $this->unreadMessages()->count(),
        ]);
    }

    public function hasCommentedOn(Argument $argument): bool
    {
        return $this->argumentComments
            ->contains(fn (ArgumentComment $comment) => $comment->argument_id === $argument->id);
    }
}
