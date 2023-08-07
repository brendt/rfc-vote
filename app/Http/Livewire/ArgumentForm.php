<?php

namespace App\Http\Livewire;

use App\Models\Rfc;
use App\Models\User;
use Livewire\Component;

class ArgumentForm extends Component
{
    public Rfc $rfc;

    public User $user;

    public ?string $body = null;

    protected $listeners = [
        Events::USER_VOTED->value => 'handleUserVoteChanged',
        Events::USER_UNDO_VOTE->value => 'handleUserVoteChanged',
    ];

    public function mount()
    {
        $existingArgument = $this->user->getArgumentForRfc($this->rfc);

        $this->body = $existingArgument?->body;
    }

    public function render()
    {
        $existingArgument = $this->user->getArgumentForRfc($this->rfc);
        $vote = $this->user->getVoteForRfc($this->rfc);
        $rowCount = count(explode(PHP_EOL, $this->body ?? '')) + 1;

        return view('livewire.argument-form', [
            'vote' => $vote,
            'existingArgument' => $existingArgument,
            'rowCount' => $rowCount,
        ]);
    }

    public function handleUserVoteChanged(): void
    {
        $this->user->refresh();
        $this->rfc->refresh();
    }

    public function storeArgument(): void
    {
        if (! $this->body) {
            return;
        }

        $this->user->saveArgument($this->rfc, $this->body);

        $this->user->refresh();
        $this->rfc->refresh();

        $this->emit(Events::ARGUMENT_CREATED);
    }
}
