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
    @endforeach

    {{ $arguments->links('vendor.pagination.tailwind') }}
</div>
