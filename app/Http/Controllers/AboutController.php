<?php

namespace App\Http\Controllers;

use App\Models\Contributor;
use Illuminate\Contracts\View\View;

final readonly class AboutController
{
    public function __invoke(): View
    {
        $content = file_get_contents(__DIR__.'/../../../contributors.json');
        $people = json_decode(file_get_contents(__DIR__.'/../../../contributors.json') ?: '{}', true);

        $contributors = array_map(
            fn (array $item) => new Contributor(...$item),
            $people['contributors'] ?? [],
        );

        shuffle($contributors);

        return view('about', compact('contributors'));
    }
}
