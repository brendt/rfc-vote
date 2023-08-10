<?php

namespace App\Http\Livewire;

use App\Http\Controllers\RfcDetailController;
use App\Models\Rfc;
use App\Models\User;
use App\Models\VoteType;
use Livewire\Component;
use Session;

class VoteBar extends Component
{
    public Rfc $rfc;

    public ?User $user = null;

    protected $listeners = [
        Events::ARGUMENT_CREATED->value => 'handleArgumentCreated',
    ];

    public function render()
    {
        $userVote = $this->user?->getVoteForRfc($this->rfc);
        $userArgument = $this->user?->getArgumentForRfc($this->rfc);

        return view('livewire.vote-bar', [
            'userVote' => $userVote,
            'userArgument' => $userArgument,
        ]);
    }

    public function vote(string $voteType): void
    {
        if (! $this->user) {
            Session::put('url.intended', action(RfcDetailController::class, $this->rfc));
            $this->redirect(route('login'));

            return;
        }

        $this->user->createVote($this->rfc, VoteType::from($voteType));

        $this->user->refresh();
        $this->rfc->refresh();

        $this->emit(Events::USER_VOTED);
        $this->emit(Events::REPUTATION_UPDATED);
    }

    public function undo(): void
    {
        $this->user->undoVote($this->rfc);

        $this->user->refresh();
        $this->rfc->refresh();

        $this->emit(Events::USER_UNDO_VOTE);
        $this->emit(Events::REPUTATION_UPDATED);
    }

    public function handleArgumentCreated(): void
    {
        $this->user->refresh();
    }
}
