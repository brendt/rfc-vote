<div class="bg-white rounded-xl shadow-sm p-6 flex gap-6 items-center">
    <x-argument-card.vote :argument="$argument" :user="$user" />

    <div class="grid gap-2 md:gap-4 w-full">
        @if($isEditing?->is($argument))
            <textarea wire:model="body" class="border-gray-200 rounded-lg" rows="5"></textarea>
        @else
            <x-markdown class="prose prose-md w-full max-w-full">
                {!! $argument->body !!}
            </x-markdown>
        @endif

        <div class="flex gap-2 items-center justify-between">
            <div class="flex items-center gap-1">
                <x-user-name :user="$argument->user"/>@if($argument->body_updated_at !== null)
                    (edited at {{ $argument->body_updated_at->format("Y-m-d H:i") }})
                @endif
            </div>
            <div class="flex gap-2 items-center">
                @if($user?->canEditArgument($argument))
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

                @if($user?->canDeleteArgument($argument))
                    <x-argument-card.delete-button
                        :argument="$argument"
                        :is-confirming-delete="$isConfirmingDelete"
                    />
                @endif
            </div>
        </div>
    </div>
</div>
