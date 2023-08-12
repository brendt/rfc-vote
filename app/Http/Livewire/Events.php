<?php

namespace App\Http\Livewire;

enum Events: string
{
    case ARGUMENT_CREATED = 'argument_created';
    case ARGUMENT_DELETED = 'argument_deleted';
    case USER_VOTED_FOR_ARGUMENT = 'user_voted_for_argument';
}
