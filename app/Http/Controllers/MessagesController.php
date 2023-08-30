<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

final readonly class MessagesController
{
    public function __invoke(): View
    {
        $user = auth()->user()?->load([
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
