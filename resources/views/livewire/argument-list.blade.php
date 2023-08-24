<div class="grid gap-4 md:gap-6">
    @if($user)
        <div class="px-2">
            @php
                $availableVotes = $user->getAvailableVotesForRfc($rfc);
            @endphp

            <span class="text-gray-600 tracking-wide">
                You have {{ $availableVotes }} {{ Str::plural('vote', $availableVotes) }} available
            </span>
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

    @foreach($rfc->arguments as $argument)
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
</div>
