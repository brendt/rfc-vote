@php
    use App\Models\Argument;
    use App\Models\Rfc;
    use App\Models\User;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Support\Collection;

    /**
     * @var User|null $user
     * @var Rfc $rfc
     * @var Argument|null $userArgument
     * @var LengthAwarePaginator<Argument> $arguments
     * @var Collection<int, Argument> $yesArguments
     * @var Collection<int, Argument> $noArguments
     */
@endphp

<div class="grid gap-4 md:gap-6">
    @if($user)
        <div class="px-2 flex justify-between items-center">
            @php
                $availableVotes = $user->getAvailableVotesForRfc($rfc);
            @endphp

            <span class="text-font tracking-wide">
                You have {{ $availableVotes }} {{ Str::plural('vote', $availableVotes) }} available
            </span>

            <select
                name="sortField"
                id="sortField"
                wire:model="sortField"
                class="border-divider bg-transparent rounded-lg pl-4 text-font text-sm ring-1 ring-transparent focus:border-purple-300 focus:ring-purple-500/50 focus:outline-none"
            >
                @foreach(App\Http\Livewire\SortField::cases() as $sortField)
                    <option value="{{ $sortField->value }}">{{ $sortField->getDescription() }}</option>
                @endforeach
            </select>
        </div>
    @endif

    @if($userArgument)
        <x-argument-card.card
            :user="$user"
            :rfc="$rfc"
            :argument="$userArgument"
            :is-confirming-delete="$isConfirmingDelete"
            :is-editing="$isEditing"
        />
    @endif

    @foreach($arguments as $argument)
        @if ($userArgument?->is($argument))
            @continue
        @endif

        <x-argument-card.card
            :user="$user"
            :rfc="$rfc"
            :argument="$argument"
            :is-confirming-delete="$isConfirmingDelete"
            :is-editing="$isEditing"
        />

        @if($showingComments?->is($argument))
            <div class="grid gap-2">
                @foreach($argument->comments as $comment)
                    <div class="md:pl-24 pl-4">
                        <div class="bg-white p-4 rounded-md prose w-full max-w-full">
                            <span
                                class="font-bold">{{ $comment->user->name }}</span>: {{ $comment->body }}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endforeach

    {{ $arguments->links('vendor.pagination.tailwind') }}
</div>
