<?php

namespace App\Http\Controllers;

use App\Models\Contributor;
use Illuminate\Contracts\View\View;

final readonly class AboutController
{
    public function __invoke(): View
    {
        $contributors = array_map(
            fn (array $item) => new Contributor(...$item),
            json_decode(file_get_contents(__DIR__.'/../../../contributors.json'), true)['contributors'] ?? [],
        );

        return view('about', [
            'contributors' => $contributors,
        ]);
    }
}
