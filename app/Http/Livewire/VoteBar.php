<?php

namespace App\Http\Livewire;

use App\Models\Vote;
use Livewire\Component;

class VoteBar extends Component
{
    public Vote $vote;

    protected $listeners = [
        'argumentSubmit' => 'handleArgumentSubmit',
    ];

    public function render()
    {
        return view('livewire.vote-bar');
    }

    public function handleArgumentSubmit(): void
    {
        $this->vote->refresh();
    }
}
