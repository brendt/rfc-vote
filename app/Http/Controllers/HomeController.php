<?php

namespace App\Http\Controllers;

use App\Models\Argument;
use App\Models\ArgumentVote;
use App\Models\Rfc;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

final readonly class HomeController
{
    public function __invoke()
    {
        $user = auth()->user();

        $rfcs = Rfc::query()
            ->where('published_at', '<=', now()->startOfDay())
            ->where(fn (Builder $builder) => $builder->whereNull('ends_at')->orWhere('ends_at', '>', now()))
            ->orderByDesc('created_at')
            ->with(['arguments', 'yesArguments', 'noArguments'])
            ->limit(3)
            ->get();

        $argumentOfTheDay = $this->getArgumentOfTheDay();

        return view('home', [
            'rfcs' => $rfcs,
            'argumentOfTheDay' => $argumentOfTheDay,
            'user' => $user,
        ]);
    }

    private function getArgumentOfTheDay(): ?Argument
    {
        $yesterday = now()->subDay()->endOfDay()->toDateTimeString();

        $row = ArgumentVote::query()
            ->select('argument_id', DB::raw('COUNT(*) as c'), DB::raw('DATE(created_at) as day'))
            ->where('created_at', '<=', $yesterday)
            ->groupBy('argument_id', 'day')
            ->orderBy('day', 'desc')
            ->orderBy('c', 'desc')
            ->with('argument')
            ->first();

        return $row?->argument;
    }
}
