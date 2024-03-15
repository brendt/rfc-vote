@php
    /**
     * @var bool $isConfirmingDelete
     * @var App\Models\User $user
     * @var App\Models\Argument $argument
     * @var Illuminate\View\ComponentAttributeBag $attributes
     */
@endphp

<div
    class="absolute top-3 z-10 right-2 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors rounded-xl w-4 h-8 flex justify-center items-center"
    x-data="{ isVisible: false }"
>
    <button
        type="button"
        @click="isVisible = !isVisible"
        @click.away="isVisible = false"
    >
        <x-icons.ellipsis-vertical class="w-7 h-7 text-font" />
    </button>

    <div
        x-cloak
        x-show="isVisible"
        class="bg-argument-card rounded-sm border border-divider divide-divider right-5 absolute divide-y"
    >
        @if ($user?->can('edit', $argument))
            <x-argument-card.button
                wire:click="editArgument('{{ $argument->id }}')"
                icon="icons.pen"
            >
                Edit
            </x-argument-card.button>
        @endif

        @if ($user?->can('delete', $argument))
            <x-argument-card.button
                wire:click="deleteArgument('{{ $argument->id }}')"
                icon="icons.trash"
            >
                Delete
            </x-argument-card.button>
        @endif
    </div>

    @if ($isConfirmingDelete?->is($argument))
        <div class="absolute right-6 bg-argument-card flex flex-col gap-2 p-3 border rounded-sm min-w-[140px]">
            <b>Are you sure?</b>

            <x-buttons.main-small
                wire:click="deleteArgument('{{ $argument->id }}')"
                class="!bg-agree hover:!bg-agree-dark"
            >
                <span wire:loading wire:target="deleteArgument('{{ $argument->id }}')">
                    <x-icons.loading class="w-4 h-4" />
                </span>
                <span wire:loading.remove wire:target="deleteArgument('{{ $argument->id }}')">
                    <x-icons.check class="w-4 h-4" />
                </span>

                Yes!
            </x-buttons.main-small>

            <x-buttons.main-small
                wire:click="cancelDeleteArgument()"
                class="!bg-disagree hover:!bg-disagree-dark"
            >
                <x-icons.cancel class="w-4 h-4" />
                No!
            </x-buttons.main-small>
        </div>
    @endif
</div>
