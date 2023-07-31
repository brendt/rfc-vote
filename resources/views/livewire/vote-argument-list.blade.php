<div class="grid gap-4">
    @foreach($vote->argumentsWithBody as $argument)
        <div class="flex justify-{{ $argument->type->getJustify() }}">
            <div
                class="
                    border-4 p-4 rounded border-gray-700
                    border-{{ $argument->type->getColor() }}-400
                ">
                    <div class="flex gap-4 flex-{{ $argument->type->getDirection() }}">
                        <div>
                            <small>
                                {{ $argument->user->name }}
                            </small>
                            <div>
                                {{ $argument->body }}
                            </div>
                        </div>

                        <button class="
                            border-2
                            @if($user?->hasVotedForArgument($argument))
                                bg-{{ $argument->type->getColor() }}-100
                                border-{{ $argument->type->getColor() }}-400
                                font-bold
                            @else
                                bg-gray-100
                                border-gray-700
                            @endif
                            p-4
                        "
                                wire:click="toggleArgumentVote({{ $argument->id }})"
                        >
                            {{ $argument->vote_count }}
                        </button>
                    </div>
            </div>
        </div>
    @endforeach
</div>
