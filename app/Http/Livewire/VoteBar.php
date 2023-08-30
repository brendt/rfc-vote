<?php

namespace App\Http\Livewire;

use App\Actions\CreateArgument;
use App\Http\Controllers\RfcDetailController;
use App\Models\Rfc;
use App\Models\User;
use App\Models\VoteType;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Session;

class VoteBar extends Component
{
    public Rfc $rfc;

    public ?User $user = null;

    public ?VoteType $voteType = null;

    public ?string $body = null;

    /**
     * @var array<string, string>
     */
    protected $listeners = [
        Events::ARGUMENT_CREATED->value => 'refresh',
        Events::ARGUMENT_DELETED->value => 'refresh',
        Events::USER_VOTED_FOR_ARGUMENT->value => 'refresh',
    ];

    public function mount(): void
    {
        $userArgument = $this->user?->getArgumentForRfc($this->rfc);

        $this->voteType = $userArgument?->vote_type;
    }

    public function render(): View
    {
        $userArgument = $this->user?->getArgumentForRfc($this->rfc);
        $rowCount = count(explode(PHP_EOL, $this->body ?? '')) + 1;
        $hasVoted = $userArgument !== null;

        return view('livewire.vote-bar', [
            'userArgument' => $userArgument,
            'rowCount' => $rowCount,
            'hasVoted' => $hasVoted,
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
        if (! $this->body || ! $this->voteType || ! $this->user instanceof User) {
            return;
        }

        (new CreateArgument)(
            rfc: $this->rfc,
            user: $this->user,
            voteType: $this->voteType,
            body: $this->body,
        );

        $this->refresh();

        $this->emit(Events::ARGUMENT_CREATED);
    }

    public function cancel(): void
    {
        $this->refresh();
    }

    public function refresh(): void
    {
        $this->user?->refresh();
        $this->rfc->refresh();

        $userArgument = $this->user?->getArgumentForRfc($this->rfc);
        $this->voteType = $userArgument?->vote_type;
    }
}
