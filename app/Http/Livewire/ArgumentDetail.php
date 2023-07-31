<?php

namespace App\Http\Livewire;

use App\Models\Argument;
use Livewire\Component;

class ArgumentDetail extends Component
{
    public Argument $argument;

    public function render()
    {
        return view('livewire.argument-detail');
    }
}
