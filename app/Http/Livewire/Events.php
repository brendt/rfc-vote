<?php

namespace App\Http\Livewire;

enum Events: string
{
    case USER_VOTED = 'user_voted';
    case REPUTATION_UPDATED = 'reputation_updated';
    case ARGUMENT_CREATED = 'argument_created';
}
