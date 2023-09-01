<?php

namespace App\Http\Controllers;

use App\Support\FetchContributors;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

final readonly class AboutController
{
    public function __invoke(FetchContributors $contributors): View
    {
        $contributors = Cache::remember('contributors', now()->addDay(), $contributors->getContributors(...));

        shuffle($contributors);

        return view('about', compact('contributors'));
    }
}
