<?php

namespace App\Http\Livewire;

use App\Actions\DeleteArgument;
use App\Actions\ToggleArgumentVote;
use App\Http\Controllers\RfcDetailController;
use App\Models\Argument;
use App\Models\Rfc;
use App\Models\User;
use App\Models\VoteType;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class ArgumentList extends Component
{
    use WithPagination;

    public Rfc $rfc;

    public ?User $user = null;

    public ?Argument $isConfirmingDelete = null;

    public ?Argument $isEditing = null;

    public ?string $body = null;

    public ?Argument $showingComments = null;

    public string $sortField = SortField::VOTE_COUNT->value;

    /**
     * @var array<string, string>
     */
    protected $listeners = [
        Events::ARGUMENT_CREATED->value => 'refresh',
    ];

    public function updatedSortField(): void
    {
        if (! $this->user) {
            return;
        }

        $this->user->update([
            'preferred_sort_field' => $this->sortField,
        ]);
    }

    public function booted(): void
    {
        if ($this->user) {
            $this->sortField = $this->user->preferred_sort_field->value;
        }
    }

    public function render(): View
    {
        $sortField = SortField::from($this->sortField);

        $userArgument = $sortField === SortField::VOTE_COUNT ?
            $this->user?->getArgumentForRfc($this->rfc)
            : null;

        $query = Argument::query()
            ->where('rfc_id', $this->rfc->id)
            ->with([
                'user',
                'rfc',
                'comments.user',
            ]);

        $query = $sortField->applySort($query);

        $arguments = $query
            ->paginate(15)
            ->setPath(action(RfcDetailController::class, $this->rfc));

        [$yesArguments, $noArguments] = $this->splitArguments($arguments);

        return view(
            'livewire.argument-list',
            compact('userArgument', 'arguments', 'yesArguments', 'noArguments'),
        );
    }

    /**
     * @param LengthAwarePaginator<Argument> $arguments
     *
     * @return array<int, Collection<int, mixed>>
     */
    private function splitArguments(LengthAwarePaginator $arguments): array
    {
        $yesArguments = $arguments
            ->filter(fn(Argument $arg) => $arg->vote_type === VoteType::YES)
            ->values();

        $noArguments = $arguments
            ->filter(fn(Argument $arg) => $arg->vote_type === VoteType::NO)
            ->values();

        return [$yesArguments, $noArguments];
    }

    public function refresh(): void
    {
        $this->rfc->refresh();
        $this->user?->refresh();
        $this->isConfirmingDelete = null;
    }

    public function voteForArgument(Argument $argument): void
    {
        if (! $this->user) {
            Session::put('url.intended', action(RfcDetailController::class, $this->rfc));
            $this->redirect(route('login'));

            return;
        }

        if ($argument->user()->is($this->user)) {
            return;
        }

        if (
            ! (
                $this->user->hasVotedForArgument($argument)
                || $this->user->can('vote', $this->rfc)
            )
        ) {
            return;
        }

        (new ToggleArgumentVote)(
            user: $this->user,
            argument: $argument,
        );

        $this->refresh();

        $this->emit(Events::USER_VOTED_FOR_ARGUMENT);
    }

    public function editArgument(Argument $argument): void
    {
        if (! $this->user) {
            return;
        }

        if (! $this->user->can('edit', $argument)) {
            return;
        }

        if (! $this->isEditing) {
            $this->isEditing = $argument;
            $this->body = $argument->body;

            return;
        }

        if (empty($this->body)) {
            return;
        }

        $this->isEditing->update([
            'body' => $this->body,
            'body_updated_at' => now(),
        ]);

        $this->isEditing = null;
        $this->body = null;
        $this->refresh();
    }

    public function cancelEditArgument(): void
    {
        $this->isEditing = null;
    }

    public function deleteArgument(Argument $argument): void
    {
        if (! $this->user) {
            return;
        }

        if (! $this->isConfirmingDelete) {
            $this->isConfirmingDelete = $argument;

            return;
        }

        (new DeleteArgument)(
            user: $this->user,
            argument: $argument,
        );

        $this->refresh();

        $this->emit(Events::ARGUMENT_DELETED);
    }

    public function cancelDeleteArgument(): void
    {
        $this->isConfirmingDelete = null;
    }

    public function openComments(Argument $argument): void
    {
        if ($this->showingComments?->is($argument)) {
            $this->showingComments = null;

            return;
        }

        $this->showingComments = $argument;
    }
}
