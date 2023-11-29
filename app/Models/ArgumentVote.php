<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read Argument $argument
 */
class ArgumentVote extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected static function booted()
    {
        self::saving(function (self $vote) {
            $vote->argument_user_id ??= $vote->argument->user_id;
            $vote->argument_rfc_id ??= $vote->argument->rfc_id;
        });
    }

    /**
     * @return BelongsTo<User, self>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Argument, self>
     */
    public function argument(): BelongsTo
    {
        return $this->belongsTo(Argument::class);
    }
}
