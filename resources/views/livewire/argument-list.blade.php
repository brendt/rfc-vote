<div class="grid gap-2 md:gap-4">
    @foreach($rfc->arguments as $argument)
        @php
            $vote = $rfc->getVoteForUser($argument->user);

            if (!$vote) {
                continue;
            }
        @endphp

        <div
            class="
                bg-white
                @if ($vote?->type === \App\Models\VoteType::YES)
                    border-l-green-400 border-l-8 md:mr-8
                @else
                    border-r-red-400 border-r-8 md:ml-8
                @endif
                shadow-md
                p-4 flex gap-4 items-center
            "
        >
            <div
                class="
                    font-bold
                    py-2 px-4 cursor-pointer
                    border-{{ $vote->type->getColor() }}-400
                    border-2
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

            <div class="grid gap-2 md:gap-4 w-full">
                <x-markdown class="prose prose-md w-full max-w-full">
                    {!! $argument->body !!}
                </x-markdown>
                <small class="flex gap-1 items-center">
                     <x-user-name :user="$argument->user" />@if($argument->body_updated_at !== null) (edited at {{ $argument->body_updated_at->format("Y-m-d H:i") }})@endif
                </small>
            </div>
        </div>
    @endforeach
</div>
