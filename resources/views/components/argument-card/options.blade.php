@php
    /**
     * @var bool $isConfirmingDelete
     * @var App\Models\User $user
     * @var App\Models\Argument $argument
     */
@endphp

<div
    class="absolute top-3 right-3 z-10 bg-white"
    x-data="{ isVisible: false }"
>
    <button
        type="button"
        class="p-2 rounded-full group-hover:bg-gray-100"
        @click="isVisible = !isVisible"
        @click.away="isVisible = false"
    >
        <x-icons.ellipsis-vertical class="w-7 h-7 text-gray-800 absolute right-0 top-0" />
    </button>

    <div
        x-cloak
        x-show="isVisible"
        class="bg-white rounded-md border right-5 absolute divide-y"
    >
        @if ($user?->can('edit', $argument))
            <x-argument-card.button
                wire:click="editArgument('{{ $argument->id }}')"
                icon="icons.pen"
            >
                {{ __('Edit') }}
            </x-argument-card.button>
        @endif

        @if ($user?->can('delete', $argument))
            <x-argument-card.button
                wire:click="deleteArgument('{{ $argument->id }}')"
                icon="icons.trash"
            >
                {{ __('Delete') }}
            </x-argument-card.button>
        @endif
    </div>

    @if ($isConfirmingDelete?->is($argument))
        <div class="absolute right-6 bg-white flex flex-col gap-2 p-3 border rounded-md min-w-[140px]">
            <b>{{ __('Are you sure?') }}</b>

            <x-buttons.main-small
                wire:click="deleteArgument('{{ $argument->id }}')"
                class="!bg-agree hover:!bg-agree-dark"
            >
                <x-icons.check class="w-4 h-4" />
                {{ __('Yes') }}!
            </x-buttons.main-small>

            <x-buttons.main-small
                wire:click="cancelDeleteArgument()"
                class="!bg-disagree hover:!bg-disagree-dark"
            >
                <x-icons.cancel class="w-4 h-4" />
                {{ __('No') }}!
            </x-buttons.main-small>
        </div>
    @endif
</div>
