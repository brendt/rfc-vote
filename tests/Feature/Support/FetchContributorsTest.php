<?php

namespace Tests\Feature\Support;

use App\Support\FetchContributors;
use Illuminate\Support\Arr;
use Tests\TestCase;

class FetchContributorsTest extends TestCase
{
    protected array $contributors;

    public function test_no_duplicates_in_contributors_json()
    {
        $this->assertCount(0,
            $duplicates = collect($this->contributors)->duplicates('id'),
            sprintf('ID %s is in contributors.json more than once.', Arr::first($duplicates))
        );
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->contributors = app(FetchContributors::class)->getJson();
    }
}
