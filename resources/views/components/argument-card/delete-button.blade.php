<div class="flex flex-col md:flex-row items-center justify-center gap-1">
    @if($isConfirmingDelete?->is($argument))
        <span class="font-bold text-red-500 px-2">
            Are you sure?
        </span>
    @endif

    <x-argument-card.button
        wire:click="deleteArgument('{{ $argument->id }}')"
        class="{{ $isConfirmingDelete?->is($argument) ? 'hover:text-green-600' : 'hover:text-red-600 border-transparent !px-3' }}"
        :icon="$isConfirmingDelete?->is($argument) ? 'icons.check' : 'icons.trash'"
    >
        {{ $isConfirmingDelete?->is($argument) ? 'Yes!' : 'Delete' }}
    </x-argument-card.button>

    @if($isConfirmingDelete?->is($argument))
        <x-argument-card.button
            wire:click="cancelDeleteArgument()"
            class="hover:text-red-600"
            icon="icons.cancel"
        >
            Cancel
        </x-argument-card.button>
    @endif
</div>
