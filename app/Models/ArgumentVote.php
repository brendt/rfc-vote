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
