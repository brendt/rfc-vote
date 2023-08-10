<div class="grid gap-2 md:gap-4">
    @if($userArgument)
        <x-argument-card
            :vote="$rfc->getVoteForUser($userArgument->user)"
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

            $vote = $rfc->getVoteForUser($argument->user);

            if (! $vote) {
                continue;
            }
        @endphp

        <x-argument-card
            :vote="$vote"
            :user="$user"
            :rfc="$rfc"
            :argument="$argument"
            :is-confirming-delete="$isConfirmingDelete"
            :is-editing="$isEditing"
        />
    @endforeach
</div>
