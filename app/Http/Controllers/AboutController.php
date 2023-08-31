<?php

namespace App\Http\Controllers;

use App\Models\Contributor;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use JsonException;

final readonly class AboutController
{
    private const DAY = 60 * 60 * 24;

    public function __invoke(): View
    {
        $contributors = Cache::remember('contributors', self::DAY, $this->getContributors(...));

        shuffle($contributors);

        return view('about', compact('contributors'));
    }

    /**
     * @return Contributor[]
     * @throws JsonException
     */
    private function getContributors(): array
    {
        /**
         * @var array{
         *     contributors: array<int, array{
         *         id: int,
         *         name: string,
         *         url: string,
         *         contributions: array<int, string>,
         *     }>
         * } $contributors
         */
        $contributors = File::json(__DIR__.'/../../../contributors.json', JSON_THROW_ON_ERROR);

        return collect($contributors['contributors'])
            ->map(fn (array $contributor) => new Contributor(...$contributor))
            ->all();
    }
}
