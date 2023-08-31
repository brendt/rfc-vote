<?php

namespace Tests\Feature;

use App\Http\Controllers\AboutController;
use App\Models\Contributor;
use App\Support\FetchContributors;
use Mockery\MockInterface;
use Tests\TestCase;

class AboutTest extends TestCase
{
    public function test_it_has_contributors(): void
    {
        $contributors = [
            new Contributor(...[
                'id' => 6905297,
                'name' => 'Brent',
                'url' => 'https://github.com/brendt',
                'contributions' => ['Frontend', 'Backend'],
            ]),
        ];

        $this->mock(FetchContributors::class, function (MockInterface $mock) use ($contributors) {
            $mock->shouldReceive('getJson')->andReturn([]);
            $mock->shouldReceive('getContributors')->andReturn($contributors);
        });

        $response = $this->get(action(AboutController::class));
        $response->assertStatus(200);
        $response->assertViewHas('contributors', $contributors);
    }
}
