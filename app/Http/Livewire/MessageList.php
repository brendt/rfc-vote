<?php

namespace App\Http\Livewire;

use App\Models\Message;
use App\Models\MessageStatus;
use App\Models\User;
use Livewire\Component;

class MessageList extends Component
{
    public User $user;

    public function render()
    {
        return view('livewire.message-list');
    }

    public function read(Message $message): void
    {
        $message->update([
            'status' => MessageStatus::READ,
        ]);

        $message->user->updateUnreadMessageCount();

        $this->refresh();
    }

    public function unread(Message $message): void
    {
        $message->update([
            'status' => MessageStatus::UNREAD,
        ]);

        $message->user->updateUnreadMessageCount();

        $this->refresh();
    }

    public function archive(Message $message): void
    {
        $message->update([
            'status' => MessageStatus::ARCHIVED,
        ]);

        $message->user->updateUnreadMessageCount();

        $this->refresh();
    }

    public function refresh(): void
    {
        $this->user->refresh();
    }
}
