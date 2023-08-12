<?php

namespace App\Models;

enum ReputationType
{
    case VOTE_FOR_ARGUMENT;
    case CREATE_ARGUMENT;
    case GAIN_ARGUMENT_VOTE;

    public function getPoints(): int
    {
        return match ($this) {
            self::GAIN_ARGUMENT_VOTE => 10,
            self::VOTE_FOR_ARGUMENT => 1,
            self::CREATE_ARGUMENT => 20,
        };
    }
}
