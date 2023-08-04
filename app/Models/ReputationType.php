<?php

namespace App\Models;

enum ReputationType
{
    case VOTE_FOR_RFC;
    case VOTE_FOR_ARGUMENT;
    case MAKE_ARGUMENT;
    case GAIN_ARGUMENT_VOTE;

    public function getPoints(): int
    {
        return match ($this) {
            self::VOTE_FOR_RFC, self::GAIN_ARGUMENT_VOTE => 10,
            self::VOTE_FOR_ARGUMENT => 1,
            self::MAKE_ARGUMENT => 20,
        };
    }
}
