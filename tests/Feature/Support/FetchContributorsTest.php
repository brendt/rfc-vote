<?php

use App\Models\Contributor;
use App\Support\FetchContributors;
use Illuminate\Support\Arr;

test('no duplicates in contributors json', function () {
    $contributors = app(FetchContributors::class)->getJson();

    expect($duplicates = collect($contributors)->duplicates('id'))->toHaveCount(0, sprintf('ID %s is in contributors.json more than once.', Arr::first($duplicates)));
});

test('get contributors returns an array of contributor models', function () {
    $contributors = app(FetchContributors::class)->getContributors();

    $this->assertContainsOnlyInstancesOf(Contributor::class, $contributors);
});
