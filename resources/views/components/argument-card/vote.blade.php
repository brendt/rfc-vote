<div
    class="
            font-bold
            px-3
            py-1
            cursor-pointer
            border-{{ $argument->vote_type->getColor() }}-400
            border-2
            relative
            @if($user?->hasVotedForArgument($argument))
                bg-{{ $argument->vote_type->getColor() }}-400
                text-white
                font-bold
            @else
                bg-{{ $argument->vote_type->getColor() }}-200
                hover:bg-{{ $argument->vote_type->getColor() }}-400
                hover:text-white
                text-{{ $argument->vote_type->getColor() }}-800
            @endif
            text-center
            rounded-full
        "
        wire:click="voteForArgument({{ $argument->id }})"
>
    <x-argument-card.vote-arrow :argument="$argument"/>

    {{ $argument->vote_count }}
</div>
