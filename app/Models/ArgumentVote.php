<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArgumentVote extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        $this->belongsTo(User::class);
    }

    public function argument(): BelongsTo
    {
        $this->belongsTo(Argument::class);
    }
}
