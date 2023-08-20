@php
    /** @var \App\Models\Argument $argument */
@endphp

<div
    class="
            {{ $user?->can('vote', $argument) ?  "hover:border-gray-200 cursor-pointer" : "cursor-not-allowed" }}
            flex
            flex-col
            gap-1
            transition-colors
            py-3
            px-2
            mb-5
            max-w-[50px]
            mx-auto
            text-center
            rounded-2xl
            text-lg
            border
            border-transparent
            bg-gray-100
            box-content
            @if ($argument->vote_type->isYes())
                text-green-700
                {{ $argument->user()->is($user) ? '' : 'hover:text-green-800' }}
            @else
                text-red-700
                {{ $argument->user()->is($user) ? '' : 'hover:text-red-800' }}
            @endif
        "
    wire:click="voteForArgument({{ $argument->id }})"
>
    @if ($user?->hasVotedForArgument($argument))
        <x-icons.arrow-up-filled class="w-8 h-8 text-black m-auto text-inherit"></x-icons.arrow-up-filled>
    @elseif($user?->can('vote', $argument))
        <x-icons.arrow-up-empty class="w-8 h-8 text-black m-auto text-inherit"></x-icons.arrow-up-empty>
    @endif

    <span class="font-bold w-8">{{ $argument->vote_count }}</span>
</div>
