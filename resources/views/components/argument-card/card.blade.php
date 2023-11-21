@php
    use App\Models\Argument;
    use App\Models\User;

    /**
     * @var Argument $argument
     * @var User $user
     * @var Argument|null $isConfirmingDelete
     * @var Argument|null $isEditing
     * @var 'right'|'left'|'both' $cardSide
     */

    $readonly ??= false;
    $anchorLink = $argument->user->username . '-' . $argument->id;
@endphp

<div
    @class([
        'md:pl-24' => $cardSide === 'right',
        'md:pr-24' => $cardSide === 'left',
    ])
>
    <div
        {{ dusk('argument-card') }}
        id="{{ $anchorLink }}"
        @class([
            'bg-argument-card text-font rounded-xl group/card pt-5 px-4 md:px-7 md:pt-7 flex flex-col gap-3 md:gap-6 items-center relative',
            'border-2 border-purple-300 dark:border-purple-800' => !$readonly && $user && !$user->hasSeenArgument($argument),
            'border border-divider' => !(!$readonly && $user && !$user->hasSeenArgument($argument)),
            'md:flex-row-reverse' => $cardSide === 'right',
            'md:flex-row' => $cardSide === 'left' || $cardSide === 'both',
        ])
    >
        <x-argument-card.vote :argument="$argument" :user="$user"/>

        @if (!$readonly && ($user?->can('edit', $argument) || $user?->can('delete', $argument)))
            <x-argument-card.options
                :user="$user"
                :argument="$argument"
                :is-confirming-delete="$isConfirmingDelete"
            />
        @endif

        <div class="grid gap-2 md:gap-4 w-full">
            @if (!$readonly && $isEditing?->is($argument))
                <x-markdown-editor wire:model="body"/>

                <div class="flex items-center justify-end gap-3">
                    <x-buttons.main
                        wire:click="editArgument('{{ $argument->id }}')"
                        class="!bg-agree hover:!bg-agree-dark"
                    >
                        <span wire:loading wire:target="editArgument('{{ $argument->id }}')">
                            <x-icons.loading class="w-6 h-6"></x-icons.loading>
                        </span>
                        <span wire:loading.remove wire:target="editArgument('{{ $argument->id }}')">
                            <x-icons.check class="w-6 h-6"/>
                        </span>

                        Save
                    </x-buttons.main>

                    @if ($isConfirmingDelete?->is($argument))
                        <x-buttons.main
                            wire:click="cancelDeleteArgument()"
                            class="!bg-disagree hover:!bg-disagree-dark"
                        >
                            <x-icons.cancel class="w-6 h-6"/>
                            Cancel
                        </x-buttons.main>
                    @else
                        <x-buttons.main
                            wire:click="cancelEditArgument()"
                            class="!bg-disagree hover:!bg-disagree-dark {{ empty($this->body) && $isEditing?->is($argument) ? 'cursor-not-allowed' : '' }}"
                        >
                            <x-icons.cancel class="w-6 h-6"/>
                            Cancel
                        </x-buttons.main>
                    @endif
                </div>
            @else
                <x-markdown class="prose  prose-md w-full max-w-full break-words overflow-hidden text-font">
                    {!! $argument->body !!}
                </x-markdown>
            @endif

            <x-argument-card.card-footer
                :argument="$argument"
                :user="$user"
                :anchor-link="$anchorLink"
                :readonly="$readonly"
                :card-side="$cardSide"
            />
        </div>
    </div>
</div>
