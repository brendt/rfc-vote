<?php

namespace App\Http\Controllers;

use App\Models\Contributor;
use Illuminate\View\View;

final readonly class AboutController
{
    public function __invoke(): View
    {
        $content = file_get_contents(__DIR__ . '/../../../contributors.json');
        $people = json_decode($content, true, flags: JSON_THROW_ON_ERROR);

        $contributors = array_map(
            static fn (array $item) => new Contributor(...$item),
            $people['contributors'] ?? [],
        );

        return view('about', compact('contributors'));
    }
}
