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

    public ?VoteType $voteType = null;

    public ?string $body;

    protected $listeners = [
        Events::ARGUMENT_CREATED->value => 'refresh',
        Events::ARGUMENT_DELETED->value => 'refresh',
        Events::USER_VOTED_FOR_ARGUMENT->value => 'refresh',
    ];

    public function mount()
    {
        $userArgument = $this->user?->getArgumentForRfc($this->rfc);

        $this->voteType = $userArgument?->vote_type;
    }

    public function render()
    {
        $userArgument = $this->user?->getArgumentForRfc($this->rfc);
        $rowCount = count(explode(PHP_EOL, $this->body ?? '')) + 1;

        return view('livewire.vote-bar', [
            'userArgument' => $userArgument,
            'rowCount' => $rowCount,
        ]);
    }

    public function vote(string $voteType): void
    {
        if (! $this->user) {
            Session::put('url.intended', action(RfcDetailController::class, $this->rfc));
            $this->redirect(route('login'));

            return;
        }

        $this->voteType = VoteType::from($voteType);
    }

    public function storeArgument(): void
    {
        if (! $this->body || ! $this->voteType) {
            return;
        }

        $this->user->createArgument(
            rfc: $this->rfc,
            voteType: $this->voteType,
            body: $this->body,
        );

        $this->refresh();

        $this->emit(Events::ARGUMENT_CREATED);
    }

    public function refresh(): void
    {
        $this->user->refresh();
        $this->rfc->refresh();

        $userArgument = $this->user?->getArgumentForRfc($this->rfc);
        $this->voteType = $userArgument?->vote_type;
    }
}
