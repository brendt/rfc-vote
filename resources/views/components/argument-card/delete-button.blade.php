<div class="flex items-center gap-1">
    @if($isConfirmingDelete?->is($argument))
        <span class="font-bold text-red-500 border border-gray-300 py-1 px-3 rounded-full">
            Are you sure?
        </span>
    @endif

    <x-argument-card.button
        wire:click="deleteArgument('{{ $argument->id }}')"
        class="
            !px-1
            @if ($isConfirmingDelete?->is($argument))
                hover:text-green-600
            @else
                hover:text-red-600
            @endif
        "
    >
        @if ($isConfirmingDelete?->is($argument))
            Yes!
        @else
            <x-icons.trash class="w-5 h-5" />
        @endif
    </x-argument-card.button>

    @if($isConfirmingDelete?->is($argument))
        <x-argument-card.button
            wire:click="cancelDeleteArgument()"
            class="hover:text-red-600"
        >
            Cancel
        </x-argument-card.button>
    @endif
</div>
