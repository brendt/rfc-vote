<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArgumentVote extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function user(): BelongsTo
    {
        $this->belongsTo(User::class);
    }

    public function argument(): BelongsTo
    {
        $this->belongsTo(Argument::class);
    }
}
