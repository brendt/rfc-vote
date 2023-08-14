<div class="grid gap-2 md:gap-4">
    @if($user)
    <div class="px-8">
        @php
            $availableVotes = $user->getAvailableVotesForRfc($rfc);
        @endphp

        You have {{ $availableVotes }} {{ Str::plural('vote', $availableVotes) }} available.
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
        @php
            if ($userArgument?->is($argument)) {
                continue;
            }
        @endphp

        <x-argument-card.card
            :user="$user"
            :rfc="$rfc"
            :argument="$argument"
            :is-confirming-delete="$isConfirmingDelete"
            :is-editing="$isEditing"
        />
    @endforeach
</div>
