<div class="grid gap-2">
    @foreach($rfc->arguments as $argument)
        @php
            $voteForUser = $rfc->getVoteForUser($argument->user);
        @endphp

        <div class="flex {{ $voteForUser?->type->getJustify() }}">
            <div
                class="
                    {{ $voteForUser?->type->getBorderColor() }}
                    p-4 border-2 max-w-4xl flex gap-4 items-center
                    {{ $voteForUser?->type->getDirection() }}
                "
            >
                <div
                    class="
                        py-2 px-4 cursor-pointer
                        @if($user?->hasVotedForArgument($argument))
                            bg-{{ $voteForUser?->type->getColor() }}-400
                            text-white
                            font-bold
                        @else
                            bg-{{ $voteForUser?->type->getColor() }}-200
                            text-{{ $voteForUser?->type->getColor() }}-800
                        @endif
                        text-center
                    "
                     wire:click="voteForArgument({{ $argument->id }})"
                >
                    {{ $argument->vote_count }}
                </div>

                <div>
                    <small>
                        {{ $argument->user->name }}
                    </small>
                    <p>
                        {{ $argument->body }}
                    </p>
                </div>
            </div>
        </div>
    @endforeach
</div>
