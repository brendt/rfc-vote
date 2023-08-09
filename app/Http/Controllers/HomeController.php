<?php

namespace App\Http\Controllers;

use App\Models\Rfc;
use Illuminate\Database\Eloquent\Builder;

final readonly class HomeController
{
    public function __invoke()
    {
        $rfcs = Rfc::query()
            ->where('published_at', '<=', now()->startOfDay())
            ->where(fn (Builder $builder) => $builder->whereNull('ends_at')->orWhere('ends_at', '>', now()))
            ->orderByDesc('created_at')
            ->with(['arguments', 'yesVotes', 'noVotes'])
            ->get();

        return view('home', [
            'rfcs' => $rfcs,
        ]);
    }
}
