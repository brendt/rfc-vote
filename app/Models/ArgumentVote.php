<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ArgumentVote
 *
 * @property int $id
 * @property int $user_id
 * @property int $argument_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Argument $argument
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\ArgumentVoteFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ArgumentVote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ArgumentVote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ArgumentVote onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ArgumentVote query()
 * @method static \Illuminate\Database\Eloquent\Builder|ArgumentVote whereArgumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArgumentVote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArgumentVote whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArgumentVote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArgumentVote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArgumentVote whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArgumentVote withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ArgumentVote withoutTrashed()
 * @mixin \Eloquent
 */
class ArgumentVote extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function argument(): BelongsTo
    {
        return $this->belongsTo(Argument::class);
    }
}
