<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\MessageStatus;

final readonly class ViewMessageController
{
    public function __invoke(Message $message)
    {
        $message->update(['status' => MessageStatus::READ]);

        $message->user->updateUnreadMessageCount();

        return redirect()->to($message->url);
    }
}
