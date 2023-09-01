<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;

enum SortField: string
{
    case VOTE_COUNT = 'vote_count';
    case CREATED_AT = 'created_at';

    /**
     * @param  \Illuminate\Database\Eloquent\Builder<\App\Models\Argument>  $query
     * @return \Illuminate\Database\Eloquent\Builder<\App\Models\Argument>
     */
    public function applySort(Builder $query): Builder
    {
        return match ($this) {
            self::VOTE_COUNT => $query->orderByDesc('vote_count')->orderByDesc('created_at'),
            self::CREATED_AT => $query->orderByDesc('created_at'),
        };
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::VOTE_COUNT => 'Most votes first',
            self::CREATED_AT => 'Latest arguments first',
        };
    }
}
