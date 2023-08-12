<div
    class="
            relative
            cursor-pointer
            transition-colors
            min-w-[50px]
            text-center
            rounded-full
            group
            text-lg
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
    <x-icons.chevron-up
        class="w-5 h-5 cursor-pointer text-black m-auto -mb-1 text-inherit group-hover:-translate-y-1 transition-all group-hover:stroke-[3]"
    ></x-icons.chevron-up>

    <span class="font-bold">{{ $argument->vote_count }}</span>

    <div class="text-center">
        @if ($argument->vote_type->getColor() === 'green')
            <span class="text-[1rem] font-bold uppercase">Yes</span>
        @else
            <span class="text-[1rem] font-bold uppercase">No</span>
        @endif
    </div>

</div>
