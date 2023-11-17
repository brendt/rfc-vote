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

        $usersToNotify = $argument->comments
            ->map(fn (ArgumentComment $comment) => $comment->user)
            ->add($argument->user)
            ->reject(fn (User $other) => $other->is($user))
            ->unique(fn (User $user) => $user->id);

        foreach ($usersToNotify as $userToNotify) {
            (new SendUserMessage)(
                to: $userToNotify,
                sender: $user,
                url: action(RfcDetailController::class, ['rfc' => $argument->rfc_id, 'argument' => $argument->id]),
                body: 'wrote a new comment',
            );
        }
    }
}
