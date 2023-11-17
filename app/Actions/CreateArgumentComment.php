<?php

namespace App\Actions;

use App\Http\Controllers\RfcDetailController;
use App\Models\Argument;
use App\Models\ArgumentComment;
use App\Models\User;

final readonly class CreateArgumentComment
{
    public function __invoke(
        Argument $argument,
        User $user,
        string $body,
    ): void {
        ArgumentComment::create([
            'user_id' => $user->id,
            'argument_id' => $argument->id,
            'body' => $body,
        ]);
    }
}
