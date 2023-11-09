<?php

use App\Actions\ToggleArgumentVote;
use App\Models\Argument;
use App\Models\ReputationType;
use App\Models\User;
use App\Models\VoteType;

test('it toggle argument vote', function () {
    $user = User::factory()->create();
    $argument = Argument::factory()->create(['vote_type' => VoteType::YES]);

    (new ToggleArgumentVote)($user, $argument);

    $this->assertDatabaseHas('users', [
        'reputation' => $user->reputation
            + ReputationType::VOTE_FOR_ARGUMENT->getPoints(),
    ]);
    expect($argument->vote_count)->toEqual(1);
    expect($argument->rfc->count_yes)->toEqual(1);

    (new ToggleArgumentVote)($user->fresh(), $argument);

    $this->assertDatabaseHas('users', [
        'reputation' => $user->reputation
            - ReputationType::VOTE_FOR_ARGUMENT->getPoints(),
    ]);
    expect($argument->vote_count)->toEqual(0);
    expect($argument->rfc->count_yes)->toEqual(0);
});
