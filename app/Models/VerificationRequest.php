<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\VerificationRequest
 *
 * @property \App\Models\VerificationRequestStatus $status
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\VerificationRequestFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|VerificationRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VerificationRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VerificationRequest query()
 * @mixin \Eloquent
 */
class VerificationRequest extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => VerificationRequestStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
