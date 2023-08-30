<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\MessageStatus;
use Illuminate\Http\RedirectResponse;

final readonly class ViewMessageController
{
    public function __invoke(Message $message): RedirectResponse
    {
        $message->update(['status' => MessageStatus::READ]);

        $message->user->updateUnreadMessageCount();

        return redirect()->to($message->url);
    }
}
