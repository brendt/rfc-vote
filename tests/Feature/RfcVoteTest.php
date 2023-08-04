<?php

namespace Tests\Feature;

use App\Http\Controllers\RfcDetailController;
use App\Models\Argument;
use App\Models\Rfc;
use App\Models\VoteType;
use Tests\TestCase;

class RfcVoteTest extends TestCase
{
    /** @test */
    public function can_see_rfc_page()
    {
        $rfc = Rfc::factory()->create([
            'url' => 'https://rfc-link.test',
        ]);

        $argument = Argument::factory()->create([
            'rfc_id' => $rfc->id,
        ]);

        $argument->user->createVote($rfc, VoteType::YES);

        $this
            ->get(action(RfcDetailController::class, $rfc))
            ->assertSuccessful()
            ->assertSeeLivewire('vote-bar')
            ->assertSeeLivewire('argument-list')
            ->assertSee($rfc->title)
            ->assertSee($rfc->description)
            ->assertSee($rfc->url)
            ->assertSee($argument->body)
            ->assertSee($argument->user->name)
            ->assertDontSeeLivewire('argument-form');

        $user = $this->login();

        $user->createVote($rfc, VoteType::YES);

        $this
            ->get(action(RfcDetailController::class, $rfc))
            ->assertSuccessful()
            ->assertSeeLivewire('argument-form');
    }
}
