<?php

namespace App\Http\Controllers;

final readonly class MessagesController
{
    public function __invoke()
    {
        $user = auth()->user()->load([
            'inboxMessages.user',
            'inboxMessages.sender',
            'archivedMessages.user',
            'archivedMessages.sender',
        ]);

        return view('messages', [
            'user' => $user,
        ]);
    }
}
