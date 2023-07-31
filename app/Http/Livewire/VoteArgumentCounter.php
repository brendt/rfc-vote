<?php

namespace App\Http\Livewire;

use App\Models\Vote;
use Livewire\Component;

class VoteArgumentCounter extends Component
{
    public Vote $vote;

    protected $listeners = [
        'argumentSubmit' => 'handleArgumentSubmit',
    ];

    public function render()
    {
        return view('livewire.vote-argument-counter');
    }

    public function handleArgumentSubmit(): void
    {
        $this->vote->refresh();
    }
}
