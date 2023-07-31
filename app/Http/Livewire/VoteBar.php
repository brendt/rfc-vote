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

    public function render()
    {
        return view('livewire.vote-bar');
    }

    public function vote(string $voteType): void
    {
        if (! $this->user) {
            Session::put('url.intended', action(RfcDetailController::class, $this->rfc));
            $this->redirect(route('login'));
            return;
        }

        $this->user->createVote($this->rfc, VoteType::from($voteType));

        $this->emit('userVoted');
    }
}
