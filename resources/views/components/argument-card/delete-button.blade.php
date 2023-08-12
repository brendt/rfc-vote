<div class="flex items-center gap-1">
    @if($isConfirmingDelete?->is($argument))
        <span class="font-bold text-red-500">
            Are you sure?
        </span>
    @endif

    <x-tag-button
        wire:click="deleteArgument('{{ $argument->id }}')"
        class="bg-red-300 hover:bg-red-700 text-red-900 hover:text-white font-bold"
    >
        {{ $isConfirmingDelete?->is($argument) ? 'Yes, delete' : 'Delete' }}
    </x-tag-button>

    @if($isConfirmingDelete?->is($argument))
        <x-tag-button
            class="font-bold hover:bg-gray-700 bg-white hover:text-white"
            wire:click="cancelDeleteArgument()"
        >
            Cancel
        </x-tag-button>
    @endif
</div>
