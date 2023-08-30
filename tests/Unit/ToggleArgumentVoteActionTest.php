<?php

namespace Tests\Unit;

use App\Actions\ToggleArgumentVote;
use App\Models\Argument;
use App\Models\ReputationType;
use App\Models\User;
use App\Models\VoteType;
use Tests\TestCase;

class ToggleArgumentVoteActionTest extends TestCase
{
    public function test_it_toggle_argument_vote(): void
    {
        $user = User::factory()->create();
        $argument = Argument::factory()->create(['vote_type' => VoteType::YES]);

        (new ToggleArgumentVote)($user, $argument);

        $this->assertDatabaseHas('users', [
            'reputation' => $user->reputation
                + ReputationType::VOTE_FOR_ARGUMENT->getPoints(),
        ]);
        $this->assertEquals(1, $argument->vote_count);
        $this->assertEquals(1, $argument->rfc->count_yes);

        (new ToggleArgumentVote)($user->fresh(), $argument);

        $this->assertDatabaseHas('users', [
            'reputation' => $user->reputation
                - ReputationType::VOTE_FOR_ARGUMENT->getPoints(),
        ]);
        $this->assertEquals(0, $argument->vote_count);
        $this->assertEquals(0, $argument->rfc->count_yes);
    }
}
