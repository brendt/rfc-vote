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
        class="bg-white shadow-md rounded-md border right-5 absolute"
    >
        <div>
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
    </div>

    @if ($isConfirmingDelete?->is($argument))
        <div class="absolute right-6 bg-white flex flex-col gap-3 p-3 shadow-xl border rounded-md min-w-[140px]">
            <b>{{ __('Are you sure?') }}</b>

            <x-buttons.main
                wire:click="deleteArgument('{{ $argument->id }}')"
                class="!bg-agree hover:!bg-agree-light"
            >
                <x-icons.check class="w-6 h-6" />
                {{ __('Yes') }}!
            </x-buttons.main>

            <x-buttons.main
                wire:click="cancelDeleteArgument()"
                class="!bg-disagree hover:!bg-disagree-light"
            >
                <x-icons.cancel class="w-6 h-6" />
                {{ __('No') }}!
            </x-buttons.main>
        </div>
    @endif
</div>