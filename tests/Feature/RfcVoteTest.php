<?php

use App\Http\Controllers\RfcDetailController;
use App\Http\Livewire\VoteBar;
use App\Models\Argument;
use App\Models\ReputationType;
use App\Models\Rfc;
use App\Models\VoteType;
use Livewire\Livewire;

test('can see rfc page', function () {
    $rfc = Rfc::factory()->create([
        'url' => 'https://rfc-link.test',
    ]);

    $argument = Argument::factory()->create([
        'rfc_id' => $rfc->id,
    ]);

    $this
        ->get(action(RfcDetailController::class, $rfc))
        ->assertSuccessful()
        ->assertSeeLivewire('vote-bar')
        ->assertSeeLivewire('argument-list')
        ->assertSee($rfc->title)
        ->assertSee($rfc->description)
        ->assertSee($rfc->url)
        ->assertSee($argument->body)
        ->assertSee($argument->user->username);

    $this
        ->get(action(RfcDetailController::class, $rfc))
        ->assertSuccessful();
});

it('redirect to login page if user not authenticated', function () {
    $rfc = Rfc::factory()->create();
    Argument::factory()->create([
        'rfc_id' => $rfc->id,
    ]);

    Livewire::test(VoteBar::class, ['rfc' => $rfc])
        ->call('vote', VoteType::YES->value)
        ->assertRedirect('login');
});

it('can vote for rfc and increment reputation', function () {
    $rfc = Rfc::factory()->create();
    $user = $this->login();

    Livewire::test(VoteBar::class, ['rfc' => $rfc, 'user' => $user])
        ->assertSuccessful()
        ->set('voteType', VoteType::YES)
        ->set('body', 'test')
        ->call('storeArgument');

    $this->assertDatabaseCount('arguments', 1);

    $this->assertDatabaseHas('users', [
        'reputation' => $user->reputation
            + ReputationType::VOTE_FOR_ARGUMENT->getPoints()
            + ReputationType::GAIN_ARGUMENT_VOTE->getPoints(),
    ]);
});
