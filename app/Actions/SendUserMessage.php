<?php

namespace App\Actions;

use App\Models\Message;
use App\Models\User;

final readonly class SendUserMessage
{
    public function __invoke(User $to, User $sender, string $url, string $body): void
    {
        if ($sender->is($to)) {
            return;
        }

        Message::create([
            'user_id' => $to->id,
            'sender_id' => $sender->id,
            'url' => $url,
            'body' => $body,
        ]);

        $to->updateUnreadMessageCount();
    }
}
