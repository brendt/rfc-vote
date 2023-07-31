<?php

namespace App\Http\Livewire;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\VoteController;
use App\Models\Argument;
use App\Models\User;
use App\Models\Vote;
use App\Models\VoteType;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class VoteButton extends Component
{
    public ?User $user = null;

    public Vote $vote;

    public bool $showModal = false;

    public ?string $body = null;

    public function mount(): void
    {
        if (! $this->user) {
            return;
        }

        $this->body = $this->getArgument()->body;
    }

    public function render()
    {
        return view('livewire.vote-button');
    }

    public function showModal(): void
    {
        if (! $this->user) {
            Session::put('url.intended', action(VoteController::class, $this->vote->id));
            $this->redirect(route('login'));
            return;
        }

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function submitYes(): void
    {
        if (! $this->user) {
            return;
        }

        $argument = $this->getArgument();

        $argument->type = VoteType::YES;
        $argument->body = $this->getBody();
        $argument->save();

        $this->vote->updateCounts();

        $this->closeModal();

        $this->emit('argumentSubmit');
    }

    public function submitNo(): void
    {
        if (! $this->user) {
            return;
        }

        $argument = $this->getArgument();

        $argument->type = VoteType::NO;
        $argument->body = $this->getBody();
        $argument->save();

        $this->vote->updateCounts();

        $this->closeModal();

        $this->emit('argumentSubmit');
    }

    public function getArgument(): Argument
    {
        return $this->user->getArgumentFor($this->vote) ?? new Argument([
            'user_id' => $this->user->id,
            'vote_id' => $this->vote->id,
        ]);
    }

    private function getBody(): ?string
    {
        if ($this->body === '') {
            return null;
        }

        return $this->body;
    }
}
