<?php

namespace App\Http\Livewire;

use App\Models\Argument;
use App\Models\User;
use App\Models\Vote;
use Livewire\Component;

class VoteArgumentList extends Component
{
    public Vote $vote;

    public ?User $user = null;

    protected $listeners = [
        'argumentSubmit' => 'handleArgumentSubmit',
    ];

    public function render()
    {
        return view('livewire.vote-argument-list');
    }

    public function toggleArgumentVote(int $argumentId): void
    {
        if (! $this->user) {
            return;
        }

        $argument = Argument::find($argumentId);

        if ($this->user->hasVotedForArgument($argument)) {
            $this->user->removeArgumentVote($argument);
        } else {
            $this->user->addArgumentVote($argument);
        }

        $this->vote->refresh();
        $this->user->refresh();
    }

    public function handleArgumentSubmit(): void
    {
        $this->vote->refresh();
    }
}
