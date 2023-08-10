<?php

namespace App\Http\Livewire;

use App\Http\Controllers\RfcDetailController;
use App\Models\Argument;
use App\Models\Rfc;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ArgumentList extends Component
{
    public Rfc $rfc;

    public ?User $user = null;

    public ?Argument $isConfirmingDelete = null;

    protected $listeners = [
        Events::USER_VOTED->value => 'handleUserVoted',
        Events::ARGUMENT_CREATED->value => 'handleUserVoted',
        Events::USER_UNDO_VOTE->value => 'handleUserVoted',
    ];

    public function render()
    {
        return view('livewire.argument-list');
    }

    public function handleUserVoted(): void
    {
        $this->rfc->refresh();
    }

    public function handleArgumentCreated(): void
    {
        $this->rfc->refresh();
    }

    public function voteForArgument(Argument $argument): void
    {
        if (! $this->user) {
            Session::put('url.intended', action(RfcDetailController::class, $this->rfc));
            $this->redirect(route('login'));

            return;
        }

        $this->user->toggleArgumentVote($argument);

        $this->user->refresh();
        $this->rfc->refresh();
        $this->emit(Events::REPUTATION_UPDATED);
    }

    public function deleteArgument(Argument $argument): void
    {
        if (! $this->user) {
            return;
        }

        if (! $this->isConfirmingDelete) {
            $this->isConfirmingDelete = $argument;
            return;
        }

        $this->user->deleteArgument($argument);

        $this->user->refresh();
        $this->rfc->refresh();
        $this->isConfirmingDelete = null;
        $this->emit(Events::ARGUMENT_DELETED);
    }
}
