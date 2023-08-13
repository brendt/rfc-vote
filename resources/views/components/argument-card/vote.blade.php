@php
    /** @var \App\Models\Argument $argument */
@endphp

<div
    class="
            {{ $argument->user()->is($user) ? "cursor-not-allowed" : "hover:border-gray-200 cursor-pointer" }}
            flex
            flex-col
            gap-1
            transition-colors
            py-3
            px-2
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
    @else
        <x-icons.arrow-up-empty class="w-8 h-8 text-black m-auto text-inherit"></x-icons.arrow-up-empty>
    @endif

    <span class="font-bold">{{ $argument->vote_count }}</span>
</div>
