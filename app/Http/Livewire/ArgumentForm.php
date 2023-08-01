<?php

namespace App\Http\Livewire;

use App\Models\Rfc;
use App\Models\User;
use Livewire\Component;

class ArgumentForm extends Component
{
    public Rfc $rfc;

    public ?User $user = null;

    protected $listeners = ['userVoted' => 'handleUserVoted'];

    public function render()
    {
        return view('livewire.argument-form');
    }

    public function handleUserVoted(): void
    {
        $this->user?->refresh();
        $this->rfc->refresh();
    }
}
