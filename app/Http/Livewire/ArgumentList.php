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

    public ?Argument $isEditing = null;

    public ?string $body = null;

    protected $listeners = [
        Events::USER_VOTED->value => 'refresh',
        Events::ARGUMENT_CREATED->value => 'refresh',
        Events::USER_UNDO_VOTE->value => 'refresh',
    ];

    public function render()
    {
        $userArgument = $this->user?->getArgumentForRfc($this->rfc);

        return view('livewire.argument-list', [
            'userArgument' => $userArgument,
        ]);
    }

    public function refresh(): void
    {
        $this->rfc->refresh();
        $this->user->refresh();
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

    public function editArgument(Argument $argument): void
    {
        if (! $this->user) {
            return;
        }

        if (! $this->user->canEditArgument($argument)) {
            return;
        }

        if (! $this->isEditing) {
            $this->isEditing = $argument;
            $this->body = $argument->body;
            return;
        }

        $this->isEditing->update([
            'body' => $this->body,
            'body_updated_at' => now(),
        ]);

        $this->isEditing = null;
        $this->body = null;
        $this->refresh();
    }

    public function cancelEditArgument(): void
    {
        $this->isEditing = null;
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

    public function cancelDeleteArgument(): void
    {
        $this->isConfirmingDelete = null;
    }
}
