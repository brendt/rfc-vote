<?php

namespace App\Http\Controllers;

use App\Models\Contributor;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use JsonException;

final readonly class AboutController
{
    private const DAY = 60 * 60 * 24;

    public function __invoke(): View
    {
        $contributors = Cache::remember('contributors', self::DAY, fn () => $this->getContributors());

        shuffle($contributors);

        return view('about', compact('contributors'));
    }

    /**
     * @return Contributor[]
     * @throws JsonException
     */
    private function getContributors(): array
    {
        $content = file_get_contents(__DIR__.'/../../../contributors.json') ?: '{}';
        $people = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

        return array_map(
            static fn (array $item) => new Contributor(...$item),
            $people['contributors'] ?? [],
        );
    }
}
