<div class="bg-white rounded-xl shadow-sm p-6 flex gap-6 items-center">
    <x-argument-card.vote :argument="$argument" :user="$user" />

    <div class="grid gap-2 md:gap-4 w-full">
        @if($isEditing?->is($argument))
            <textarea wire:model="body" rows="5"></textarea>
        @else
            <x-markdown class="prose prose-md w-full max-w-full">
                {!! $argument->body !!}
            </x-markdown>
        @endif

        <small class="flex gap-2 items-center justify-between">
            <div class="flex items-center gap-1">
                <x-user-name :user="$argument->user"/>@if($argument->body_updated_at !== null)
                    (edited at {{ $argument->body_updated_at->format("Y-m-d H:i") }})
                @endif
            </div>
            <div class="flex gap-2 items-center">
                @if($user?->canEditArgument($argument))
                    <x-tag-button
                        wire:click="editArgument('{{ $argument->id }}')"
                        class="bg-blue-300 hover:bg-blue-700 text-blue-900 hover:text-white font-bold"
                    >{{ $isEditing?->is($argument) ? 'Save' : 'Edit' }}</x-tag-button>

                    @if($isEditing?->is($argument))
                        <x-tag-button
                            class="font-bold hover:bg-gray-700 bg-white hover:text-white"
                            wire:click="cancelEditArgument()"
                        >Cancel
                        </x-tag-button>
                    @endif
                @endif

                @if($user?->canDeleteArgument($argument))
                    <x-argument-card.delete-button
                        :argument="$argument"
                        :is-confirming-delete="$isConfirmingDelete"
                    />
                @endif
            </div>
        </small>
    </div>
</div>
