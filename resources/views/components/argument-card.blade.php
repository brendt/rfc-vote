<div class="bg-white rounded-xl shadow-md p-6 flex gap-6 items-center">
    <div
        class="
                    font-bold
                    px-3
                    py-1
                    cursor-pointer
                    border-{{ $argument->vote_type->getColor() }}-400
                    border-2
                    relative
                    @if($user?->hasVotedForArgument($argument))
                        bg-{{ $argument->vote_type->getColor() }}-400
                        text-white
                        font-bold
                    @else
                        bg-{{ $argument->vote_type->getColor() }}-200
                        hover:bg-{{ $argument->vote_type->getColor() }}-400
                        hover:text-white
                        text-{{ $argument->vote_type->getColor() }}-800
                    @endif
                    text-center
                    rounded-full
                "
        wire:click="voteForArgument({{ $argument->id }})"
    >
        <x-argument-vote-arrow :argument="$argument"/>

        {{ $argument->vote_count }}
    </div>

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
                    <div class="flex items-center gap-1">
                        @if($isConfirmingDelete?->is($argument))
                            <span class="font-bold text-red-500">
                                Are you sure?
                            </span>
                        @endif
                        <x-tag-button
                            wire:click="deleteArgument('{{ $argument->id }}')"
                            class="bg-red-300 hover:bg-red-700 text-red-900 hover:text-white font-bold"
                        >{{ $isConfirmingDelete?->is($argument) ? 'Yes, delete' : 'Delete' }}</x-tag-button>
                        @if($isConfirmingDelete?->is($argument))
                            <x-tag-button
                                class="font-bold hover:bg-gray-700 bg-white hover:text-white"
                                wire:click="cancelDeleteArgument()"
                            >Cancel
                            </x-tag-button>
                        @endif
                    </div>
                @endif
            </div>
        </small>
    </div>
</div>
