<?php

namespace App\Support;

use App\Models\Contributor;
use Illuminate\Support\Facades\File;

class FetchContributors
{
    /**
     * @return array<int, Contributor>
     */
    public function getContributors(): array
    {
        return collect($this->getJson())
            ->map(fn (array $contributor) => new Contributor(...$contributor))
            ->all();
    }

    /**
     * @return array<int, array{
     *     id: int,
     *     name: string,
     *     url: string,
     *     contributions: array<int, string>,
     * }>
     */
    public function getJson(): array
    {
        $contributors = File::json(base_path('contributors.json'), JSON_THROW_ON_ERROR);

        return $contributors['contributors'] ?? [];
    }
}
