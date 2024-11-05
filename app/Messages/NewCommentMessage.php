<?php

namespace App\Messages;

use App\Models\ArgumentComment;

final readonly class NewCommentMessage
{
    public function __construct(
        private ArgumentComment $comment,
    ) {
    }

    public function __toString(): string
    {
        return <<<TXT
{$this->comment->user->name} left a new comment on an argument you're following!

{$this->comment->body}
TXT;
    }
}
