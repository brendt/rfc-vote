<?php

namespace App\Models;

enum VoteType: string
{
    case YES = 'yes';
    case NO = 'no';

    public function getColor(): string
    {
        return match($this) {
            self::YES => 'bg-green-200',
            self::NO => 'bg-red-200',
        };
    }

    public function getJustify(): string
    {
        return match($this) {
            self::YES => 'justify-start',
            self::NO => 'justify-end',
        };
    }
}
