<?php

namespace App\Http\Livewire;

enum Events: string
{
    case USER_VOTED = 'user_voted';
    case USER_UNDO_VOTE = 'user_undo_vote';
    case REPUTATION_UPDATED = 'reputation_updated';
    case ARGUMENT_CREATED = 'argument_created';
    case ARGUMENT_DELETED = 'argument_deleted';
}
