<?php

namespace App\Models;

enum VoteType: string
{
    case YES = 'yes';
    case NO = 'no';

    public function getColor(): string
    {
        return match($this) {
            self::YES => 'green',
            self::NO => 'red',
        };
    }

    public function getJustify(): string
    {
        return match($this) {
            self::YES => 'start',
            self::NO => 'end',
        };
    }

    public function getDirection(): string
    {
        return match($this) {
            self::YES => 'row-reverse',
            self::NO => 'row',
        };
    }
}
