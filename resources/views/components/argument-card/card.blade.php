@php
    /**
     * @var App\Models\Argument $argument
     * @var App\Models\User $user
     */

    $readonly ??= false;
    $anchorLink = $argument->user->username . '-' . $argument->id;
@endphp

<div id="{{ $anchorLink }}" class="bg-white rounded-xl shadow-md w-full group/card pt-5 pl-4 pr-10 md:px-8 md:pt-7 flex gap-6 items-center relative">
    <x-argument-card.vote :argument="$argument" :user="$user" />

    @if (!$readonly && ($user?->can('edit', $argument) || $user?->can('delete', $argument)))
        <x-argument-card.options
            :user="$user"
            :argument="$argument"
            :is-confirming-delete="$isConfirmingDelete"
        />
    @endif

    <div class="grid gap-2 md:gap-4 w-full">
        @if (!$readonly && $isEditing?->is($argument))
            <x-markdown-editor wire:model="body" />

            <div class="flex items-center justify-end gap-3">
                <x-buttons.main
                    wire:click="editArgument('{{ $argument->id }}')"
                    class="!bg-agree hover:!bg-agree-dark"
                >
                    <x-icons.check class="w-6 h-6" />
                    {{ __('Save') }}
                </x-buttons.main>

                @if ($isConfirmingDelete?->is($argument))
                    <x-buttons.main
                        wire:click="cancelDeleteArgument()"
                        class="!bg-disagree hover:!bg-disagree-dark"
                    >
                        <x-icons.cancel class="w-6 h-6" />
                        {{ __('Cancel') }}
                    </x-buttons.main>
                @else
                    <x-buttons.main
                        wire:click="cancelEditArgument()"
                        class="!bg-disagree hover:!bg-disagree-dark {{ empty($this->body) && $isEditing?->is($argument) ? 'cursor-not-allowed' : '' }}"
                    >
                        <x-icons.cancel class="w-6 h-6" />
                        {{ __('Cancel') }}
                    </x-buttons.main>
                @endif
            </div>
        @else
            <x-markdown class="prose prose-md w-full max-w-full break-words overflow-hidden">
                {!! $argument->body !!}
            </x-markdown>
        @endif

        <x-argument-card.card-footer
            :argument="$argument"
            :user="$user"
            :anchor-link="$anchorLink"
            :readonly="$readonly"
        />
    </div>
</div>
