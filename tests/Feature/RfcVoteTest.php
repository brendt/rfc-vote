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
    }
}
