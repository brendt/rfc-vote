<?php

namespace Tests\Feature;

use App\Http\Livewire\ArgumentList;
use App\Models\Argument;
use App\Models\Vote;
use App\Models\VoteType;
use Livewire\Livewire;
use Tests\TestCase;

class ArgumentTest extends TestCase
{
    /** @test */
    public function admin_can_delete_any_argument()
    {
        $user = $this->login(null, true);
        $argument = Argument::factory()->create();

        Livewire::test(ArgumentList::class, ['rfc' => $argument->rfc, 'user' => $user])
            ->call('deleteArgument', $argument->id)
            ->assertNotSet('isConfirmingDelete', null)
            ->call('deleteArgument', $argument->id)
            ->assertSet('isConfirmingDelete', null)
            ->assertOk();

        $this->assertTrue($user->canDeleteArgument($argument));
        $this->assertDatabaseCount('arguments', 0);
    }

    /** @test */
    public function delete_can_be_canceled()
    {
        $user = $this->login(null, true);
        $argument = Argument::factory()->create();

        Livewire::test(ArgumentList::class, ['rfc' => $argument->rfc, 'user' => $user])
            ->call('deleteArgument', $argument->id)
            ->assertNotSet('isConfirmingDelete', null)
            ->call('cancelDeleteArgument', $argument->id)
            ->assertSet('isConfirmingDelete', null)
            ->assertOk();

        $this->assertDatabaseCount('arguments', 1);
    }

    /** @test */
    public function user_can_delete_only_his_own_arguments()
    {
        $vote = Vote::factory()->create([
            'type' => VoteType::YES,
        ]);
        $arguments = Argument::factory(2)->sequence(
            [
                'rfc_id' => $vote->rfc_id,
                'user_id' => $vote->user->id,
            ],
            [
                'rfc_id' => $vote->rfc_id,
            ],
        )->create();

        Livewire::test(ArgumentList::class, ['rfc' => $vote->rfc, 'user' => $vote->user])
            ->call('deleteArgument', $arguments[0]->id)
            ->assertNotSet('isConfirmingDelete', null)
            ->call('deleteArgument', $arguments[0]->id)
            ->assertSet('isConfirmingDelete', null)
            ->assertOk();

        $this->assertTrue($vote->user->canDeleteArgument($arguments[0]));
        $this->assertFalse($vote->user->canDeleteArgument($arguments[1]));
        $this->assertDatabaseCount('arguments', 1);
    }

    /** @test */
    public function admin_can_edit_argument()
    {
        $user = $this->login(null, true);
        $argument = Argument::factory()->create();

        Livewire::test(ArgumentList::class, ['rfc' => $argument->rfc, 'user' => $user])
            ->call('editArgument', $argument->id)
            ->assertNotSet('isEditing', null)
            ->assertNotSet('body', null)
            ->call('editArgument', $argument->id)
            ->assertSet('isEditing', null)
            ->assertSet('body', null)
            ->assertOk();

        $this->assertTrue($user->canEditArgument($argument));
    }

    /** @test */
    public function user_can_edit_only_his_own_arguments()
    {
        $vote = Vote::factory()->create([
            'type' => VoteType::YES,
        ]);
        $arguments = Argument::factory(2)->sequence(
            [
                'rfc_id' => $vote->rfc_id,
                'user_id' => $vote->user->id,
            ],
            [
                'rfc_id' => $vote->rfc_id,
            ],
        )->create();

        Livewire::test(ArgumentList::class, ['rfc' => $vote->rfc, 'user' => $vote->user])
            ->call('editArgument', $arguments[1]->id)
            ->assertSet('isEditing', null)
            ->assertSet('body', null)
            ->assertOk();

        $this->assertTrue($vote->user->canEditArgument($arguments[0]));
        $this->assertFalse($vote->user->canEditArgument($arguments[1]));
    }
}
