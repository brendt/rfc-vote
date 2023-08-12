<?php

namespace App\Http\Livewire;

use App\Actions\DeleteArgument;
use App\Actions\ToggleArgumentVote;
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
        Events::ARGUMENT_CREATED->value => 'refresh',
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
        $this->isConfirmingDelete = null;
    }

    public function voteForArgument(Argument $argument): void
    {
        if (! $this->user) {
            Session::put('url.intended', action(RfcDetailController::class, $this->rfc));
            $this->redirect(route('login'));

            return;
        }

        if ($argument->user()->is($this->user)) {
           return;
        }

        (new ToggleArgumentVote)(
            user: $this->user,
            argument: $argument,
        );

        $this->refresh();

        $this->emit(Events::USER_VOTED_FOR_ARGUMENT);
    }

    public function editArgument(Argument $argument): void
    {
        if (! $this->user) {
            return;
        }

        if (! $this->user->can('edit', $argument)) {
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

        (new DeleteArgument)(
            user: $this->user,
            argument: $argument,
        );

        $this->refresh();

        $this->emit(Events::ARGUMENT_DELETED);
    }

    public function cancelDeleteArgument(): void
    {
        $this->isConfirmingDelete = null;
    }
}
