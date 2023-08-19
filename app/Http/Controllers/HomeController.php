<?php

namespace App\Http\Controllers;

use App\Models\Argument;
use App\Models\Rfc;
use DB;
use Illuminate\Database\Eloquent\Builder;

final readonly class HomeController
{
    public function __invoke()
    {
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
        ]);
    }

    private function getArgumentOfTheDay(): ?Argument
    {
        $yesterday = now()->subDay()->endOfDay()->toDateTimeString();

        $row = DB::select(<<<SQL
        SELECT argument_id, COUNT(*) as c, DATE(created_at) as day
        FROM argument_votes
        WHERE created_at <= "$yesterday"
        GROUP BY argument_id, day
        ORDER BY day DESC, c DESC
        LIMIT 1
        SQL)[0] ?? null;

        if (! $row) {
            return null;
        }

        return Argument::find($row->argument_id);
    }
}
