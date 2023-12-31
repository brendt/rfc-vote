<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read User $user
 */
class Message extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => MessageStatus::class,
    ];

    /**
     * @return BelongsTo<User, self>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<User, self>
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isRead(): bool
    {
        return $this->status === MessageStatus::READ;
    }

    public function isUnread(): bool
    {
        return $this->status === MessageStatus::UNREAD;
    }

    public function isArchived(): bool
    {
        return $this->status === MessageStatus::ARCHIVED;
    }
}
