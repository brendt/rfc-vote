@php
    /** @var \App\Models\Argument $argument */
    /** @var \App\Models\User $user */
    $readonly ??= false;
    $anchorLink = $argument->user->username.'-'.$argument->id;
@endphp

<div id="{{$anchorLink}}" class="
    {{ ($user && ! $user->hasSeenArgument($argument)) ? 'border-blue-400' : 'border-transparent' }}
    border-2
    bg-white
    rounded-xl shadow-sm px-3 py-4 md:p-6 flex gap-6 items-center">

    <x-argument-card.vote :argument="$argument" :user="$user" />

    <div class="grid gap-2 md:gap-4 w-full">
        @if(!$readonly && $isEditing?->is($argument))
            <x-markdown-editor wire:model="body" />
        @else
            <x-markdown class="prose prose-md w-full max-w-full">
                {!! $argument->body !!}
            </x-markdown>
        @endif

        <div class="flex gap-2 flex-col md:flex-row md:items-center md:justify-between">
            <div class="flex items-center gap-1 text-sm">
                <x-user-name :user="$argument->user" />
                <span @class([
                    'p-1 px-2 rounded-full text-white ml-1 font-bold text-xs',
                    'bg-green-500' => $argument->vote_type->isYes(),
                    'bg-red-500' => $argument->vote_type->isNo(),
                ])>
                    {{ $argument->vote_type->value }}
                </span>

                @if($argument->body_updated_at !== null)
                    <span class="text-sm">
                    (edited at {{ $argument->body_updated_at->format("Y-m-d H:i") }})
                    </span>
                @endif
            </div>

            <div class="flex gap-2 flex-col md:flex-row md:items-center">
                <x-argument-card.button
                    href="{{'#'.$anchorLink}}"
                    :icon='"icons.hashtag"'
                >
                    Link
                </x-argument-card.button>

                @if(!$readonly && $user?->can('edit', $argument))
                    <x-argument-card.button
                        wire:click="editArgument('{{ $argument->id }}')"
                        class="{{ $isEditing?->is($argument) ? 'hover:text-green-800' : 'hover:text-blue-900' }}"
                        :icon="$isEditing?->is($argument) ? 'icons.check' : 'icons.pen'"
                    >
                        {{ $isEditing?->is($argument) ? 'Save' : 'Edit' }}
                    </x-argument-card.button>

                    @if($isEditing?->is($argument))
                        <x-argument-card.button
                            class="hover:text-red-600"
                            icon="icons.cancel"
                            wire:click="cancelEditArgument()"
                        >
                            Cancel
                        </x-argument-card.button>
                    @endif
                @endif

                @if(!$readonly && $user?->can('delete', $argument))
                    <x-argument-card.delete-button
                        :argument="$argument"
                        :is-confirming-delete="$isConfirmingDelete"
                    />
                @endif
                @if($readonly)
                    <span class="text-sm">
                    Read the RFC: <a href="{{ action(\App\Http\Controllers\RfcDetailController::class, $rfc) }}" class="underline hover:no-underline">{{ $rfc->title }}</a>
                    </span>
                @endif
            </div>
        </div>

    </div>
</div>
