<?php

namespace App\Http\Livewire;

use App\Models\Rfc;
use App\Models\VoteType;
use Livewire\Component;

class RfcCounter extends Component
{
    public VoteType $voteType;

    public Rfc $rfc;

    protected $listeners = [
        Events::USER_VOTED_FOR_ARGUMENT->value => 'refresh',
        Events::ARGUMENT_DELETED->value => 'refresh',
        Events::ARGUMENT_CREATED->value => 'refresh',
    ];

    public function booted()
    {
        $this->rfc = $this->rfc->withoutRelations();
    }

    public function render()
    {
        $count = match ($this->voteType) {
            VoteType::YES => $this->rfc->count_yes,
            VoteType::NO => $this->rfc->count_no,
        };

        $icon = match ($this->voteType) {
            VoteType::YES => <<<'SVG'
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                 class="w-4 h-4 text-gray-700">
                <path fill-rule="evenodd"
                      d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm.53 5.47a.75.75 0 00-1.06 0l-3 3a.75.75 0 101.06 1.06l1.72-1.72v5.69a.75.75 0 001.5 0v-5.69l1.72 1.72a.75.75 0 101.06-1.06l-3-3z"
                      clip-rule="evenodd"/>
            </svg>
            SVG,
            VoteType::NO => <<<'SVG'
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                         class="w-4 h-4 text-gray-700">
                <path fill-rule="evenodd"
                      d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-.53 14.03a.75.75 0 001.06 0l3-3a.75.75 0 10-1.06-1.06l-1.72 1.72V8.25a.75.75 0 00-1.5 0v5.69l-1.72-1.72a.75.75 0 00-1.06 1.06l3 3z"
                      clip-rule="evenodd"/>
            </svg>
            SVG,
        };

        return view('livewire.rfc-counter', [
            'count' => $count,
            'icon' => $icon,
        ]);
    }

    public function refresh(): void
    {
        $this->rfc->refresh();
    }
}
