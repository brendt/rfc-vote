@php
    $arrowClasses = 'w-8 h-8 cursor-pointer text-black m-auto text-inherit';
@endphp

<div
    class="
            cursor-pointer
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
            hover:border-gray-200
            box-content
            @if ($argument->vote_type->getColor() === 'green')
                text-green-700
                hover:text-green-800
            @else
                text-red-700
                hover:text-red-800
            @endif
        "
        wire:click="voteForArgument({{ $argument->id }})"
>
    @if ($user?->hasVotedForArgument($argument))
        <x-icons.arrow-up-filled class="{{ $arrowClasses }}"></x-icons.arrow-up-filled>
    @else
        <x-icons.arrow-up-empty class="{{ $arrowClasses }}"></x-icons.arrow-up-empty>
    @endif

    <span class="font-bold">{{ $argument->vote_count }}</span>
</div>
