@php
    use App\Models\Argument;
    use App\Models\Rfc;
    use App\Models\User;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Support\Collection;
    use App\Http\Livewire\SortField;

    /**
     * @var User|null $user
     * @var Rfc $rfc
     * @var Argument|null $userArgument
     * @var LengthAwarePaginator<Argument> $arguments
     * @var Collection<int, Argument> $yesArguments
     * @var Collection<int, Argument> $noArguments
     * @var int $countDominantVotes
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
                @foreach(SortField::cases() as $sortField)
                    <option value="{{ $sortField->value }}">{{ $sortField->getDescription() }}</option>
                @endforeach
            </select>
        </div>
    @endif

    {{-- todo: think about what to do with user argument --}}
{{--    @if($userArgument)--}}
{{--        <x-argument-card.card--}}
{{--            :user="$user"--}}
{{--            :rfc="$rfc"--}}
{{--            :argument="$userArgument"--}}
{{--            :is-confirming-delete="$isConfirmingDelete"--}}
{{--            :is-editing="$isEditing"--}}
{{--        />--}}
{{--    @endif--}}

    <div class="space-y-4">
        @for ($i = 0; $i < $countDominantVotes; $i++)
            @isset($yesArguments[$i])
                <x-argument-card.card
                    :user="$user"
                    :rfc="$rfc"
                    :argument="$yesArguments[$i]"
                    :is-confirming-delete="$isConfirmingDelete"
                    :is-editing="$isEditing"
                />
            @endisset

            @isset($noArguments[$i])
                <x-argument-card.card
                    :user="$user"
                    :rfc="$rfc"
                    :argument="$noArguments[$i]"
                    :is-confirming-delete="$isConfirmingDelete"
                    :is-editing="$isEditing"
                />
            @endisset
        @endfor
    </div>

    {{ $arguments->links('vendor.pagination.tailwind') }}
</div>
