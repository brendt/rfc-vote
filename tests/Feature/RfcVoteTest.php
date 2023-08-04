<?php

namespace Tests\Feature;

use App\Http\Controllers\RfcDetailController;
use App\Http\Livewire\VoteBar;
use App\Models\Argument;
use App\Models\ReputationType;
use App\Models\Rfc;
use App\Models\VoteType;
use Livewire\Livewire;
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

    /** @test */
    public function it_redirect_to_login_page_if_user_not_authenticated()
    {
        $rfc = Rfc::factory()->create();
        Argument::factory()->create([
            'rfc_id' => $rfc->id,
        ]);

        Livewire::test(VoteBar::class, ['rfc' => $rfc])
            ->call('vote', VoteType::YES->value)
            ->assertRedirect('login');
    }

    /** @test */
    public function it_can_vote_for_rfc_and_increment_reputation()
    {
        $rfc = Rfc::factory()->create();

        $user = $this->login();

        Argument::factory()->create([
            'rfc_id' => $rfc->id,
            'user_id' => $user->id,
        ]);


        Livewire::test(VoteBar::class, ['rfc' => $rfc, 'user' => $user])
            ->call('vote', VoteType::YES->value)
            ->assertSuccessful();

        $this->assertDatabaseCount('votes', 1);
        $this->assertDatabaseHas('votes', ['type' => 'yes']);
        $this->assertDatabaseHas('users', ['reputation' => $user->reputation + ReputationType::VOTE_FOR_RFC->getPoints()]);
    }

    /** @test */
    public function it_can_undo_a_vote_for_rfc_and_decrement_reputation()
    {
        $rfc = Rfc::factory()->create();
        $user = $this->login();
        $argument = Argument::factory()->create([
            'rfc_id' => $rfc->id,
            'user_id' => $user->id,
        ]);

        $user->createVote($rfc, VoteType::YES);

        Livewire::test(VoteBar::class, ['rfc' => $rfc, 'user' => $argument->user])
            ->call('undo')
            ->assertSuccessful();

        $this->assertDatabaseCount('votes', 0);
        $this->assertDatabaseMissing('votes', ['type' => 'yes']);
        $this->assertDatabaseHas('users', ['reputation' => $user->reputation - ReputationType::VOTE_FOR_RFC->getPoints()]);
    }
}
