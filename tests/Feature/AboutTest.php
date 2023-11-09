<?php

use App\Http\Controllers\AboutController;
use App\Models\Contributor;
use App\Support\FetchContributors;
use Mockery\MockInterface;

test('it has contributors', function () {
    $contributors = [
        new Contributor(...[
            'id' => 6905297,
            'name' => 'Brent',
            'url' => 'https://github.com/brendt',
            'contributions' => ['Frontend', 'Backend'],
        ]),
    ];

    $this->mock(FetchContributors::class, function (MockInterface $mock) use ($contributors) {
        $mock->shouldReceive('getContributors')->andReturn($contributors);
    });

    $response = $this->get(action(AboutController::class));
    $response->assertStatus(200);
    $response->assertViewHas('contributors', $contributors);
});
