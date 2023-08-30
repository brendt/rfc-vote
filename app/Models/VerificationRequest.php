<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read User $user
 */
class VerificationRequest extends Model
{
    use HasFactory;

    /**
     * @var array<string, string|class-string>
     */
    protected $casts = [
        'status' => VerificationRequestStatus::class,
    ];

    /**
     * @return BelongsTo<User, self>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
