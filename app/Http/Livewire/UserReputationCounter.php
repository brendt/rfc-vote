<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class UserReputationCounter extends Component
{
    public User $user;

    protected $listeners = [
        Events::REPUTATION_UPDATED->value => 'handleReputationUpdate',
        Events::ARGUMENT_CREATED->value => 'handleReputationUpdate',
        Events::USER_VOTED->value => 'handleReputationUpdate',
    ];

    public function render()
    {
        return view('livewire.user-reputation-counter');
    }

    public function handleReputationUpdate(): void
    {
        $this->user->withoutRelations()->refresh();
    }
}
