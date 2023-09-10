@php
    /**
     * @var bool $isConfirmingDelete
     * @var App\Models\User $user
     * @var App\Models\Argument $argument
     */
@endphp

<div
    class="absolute top-3 right-3 z-10 bg-argument-card"
    x-data="{ isVisible: false }"
>
    <x-buttons.more-options
        @click="isVisible = !isVisible"
        @click.away="isVisible = false"
    />

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
        <div class="absolute right-6 bg-argument-card flex flex-col gap-2 p-3 border rounded-sm min-w-[140px]">
            <b>{{ __('Are you sure?') }}</b>

            <x-buttons.main-small
                wire:click="deleteArgument('{{ $argument->id }}')"
                class="!bg-agree hover:!bg-agree-dark"
            >
                <span wire:loading wire:target="deleteArgument('{{ $argument->id }}')">
                     <x-icons.loading  class="w-4 h-4"></x-icons.loading>
                </span>
                <span wire:loading.remove wire:target="deleteArgument('{{ $argument->id }}')">
                       <x-icons.check class="w-4 h-4" />
                </span>

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
