<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\EmailChangeRequest
 *
 * @property int $id
 * @property int $user_id
 * @property string $new_email
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|EmailChangeRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailChangeRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailChangeRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailChangeRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailChangeRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailChangeRequest whereNewEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailChangeRequest whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailChangeRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailChangeRequest whereUserId($value)
 * @mixin \Eloquent
 */
class EmailChangeRequest extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
