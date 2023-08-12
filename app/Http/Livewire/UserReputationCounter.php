<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class UserReputationCounter extends Component
{
    public User $user;

    protected $listeners = [
        Events::ARGUMENT_CREATED->value => 'refresh',
    ];

    public function render()
    {
        return view('livewire.user-reputation-counter');
    }

    public function refresh(): void
    {
        $this->user->withoutRelations()->refresh();
    }
}
