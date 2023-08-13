<div class="grid gap-2 md:gap-4">
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
