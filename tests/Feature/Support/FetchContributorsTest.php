<?php

namespace Tests\Feature\Support;

use App\Models\Contributor;
use App\Support\FetchContributors;
use Illuminate\Support\Arr;
use Tests\TestCase;

class FetchContributorsTest extends TestCase
{
    public function test_no_duplicates_in_contributors_json()
    {
        $contributors = app(FetchContributors::class)->getJson();

        $this->assertCount(0,
            $duplicates = collect($contributors)->duplicates('id'),
            sprintf('ID %s is in contributors.json more than once.', Arr::first($duplicates))
        );
    }

    public function test_get_contributors_returns_an_array_of_contributor_models()
    {
        $contributors = app(FetchContributors::class)->getContributors();

        $this->assertCount(0, collect($contributors)->reject(fn ($contributor) => $contributor instanceof Contributor));
    }
}
