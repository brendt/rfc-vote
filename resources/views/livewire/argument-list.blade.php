<div class="grid gap-2 md:gap-4">
    @foreach($rfc->arguments as $argument)
        @php
            $vote = $rfc->getVoteForUser($argument->user);
        @endphp

        <div
            class="
                bg-white
                border-gray-200
                @if ($vote->type === \App\Models\VoteType::YES)
                    border-l-green-400
                    border-l-8
                    md:mr-8
                @else
                    border-r-red-400
                    border-r-8
                    md:ml-8
                @endif
                rounded
                border
                shadow-md
                p-4 flex gap-4 items-center
            "
        >
            <div
                class="
                    py-2 px-4 cursor-pointer
                    border-{{ $vote?->type->getColor() }}-400
                    border
                    @if($user?->hasVotedForArgument($argument))
                        bg-{{ $vote?->type->getColor() }}-400
                        text-white
                        font-bold
                    @else
                        bg-{{ $vote?->type->getColor() }}-200
                        hover:bg-{{ $vote?->type->getColor() }}-400
                        hover:text-white
                        text-{{ $vote?->type->getColor() }}-800
                    @endif
                    text-center
                    rounded
                "
                wire:click="voteForArgument({{ $argument->id }})"
            >
                {{ $argument->vote_count }}
            </div>

            <div class="grid gap-2 md:gap-4">
                <div>
                    {{ $argument->body }}
                </div>
                <small>
                    — {{ $argument->user->name }}@if($argument->body_updated_at !== null) (edited at {{ $argument->body_updated_at->format("Y-m-d H:i") }})@endif
                </small>
            </div>
        </div>
    @endforeach
</div>
