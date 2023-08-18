<div>
    @if (!$voteType)
        <div class="font-bold mb-3 flex justify-center">
            Click the bar to cast your vote!
        </div>
    @endif

    <div class="flex shadow-xl font-bold rounded-full overflow-hidden">
        <div
            @class([
                'p-4 flex-grow text-left md:min-w-[15%] min-w-[20%]',
                'hover:bg-green-600 hover:text-white cursor-pointer' => ! $hasVoted,
                $voteType === App\Models\VoteType::YES ? 'bg-green-600 text-white' : 'bg-green-300 text-green-900',
            ])
            style="width: {{ $rfc->percentage_yes }}%;"

            @if(! $hasVoted)
                wire:click="vote('{{ \App\Models\VoteType::YES }}')"
            @endif
        >
            {{ $rfc->percentage_yes }}%
        </div>

        <div
            class="
                    p-4 flex-grow text-right
                    md:min-w-[15%]
                    min-w-[20%]

                    @if(! $hasVoted)
                    hover:bg-red-600 hover:text-white cursor-pointer
                    @endIf

                    @if($voteType === \App\Models\VoteType::NO)
                    bg-red-600 text-white
                    @else
                    bg-red-300 text-red-900
                    @endif
                "
            style="width: {{ $rfc->percentage_no }}%;"
            @if(! $hasVoted)
                wire:click="vote('{{ \App\Models\VoteType::NO }}')"
            @endif >
            {{ $rfc->percentage_no }}%
        </div>
    </div>

    @if($voteType)
        <div class="flex justify-center mt-6 font-bold items-baseline gap-1">
            {{ $userArgument ? "You've voted" : "You're voting" }}&nbsp;<span @class([
                'p-1 px-3 rounded-full text-white shadow-md',
                'bg-green-500' => $voteType === \App\Models\VoteType::YES,
                'bg-red-500' => $voteType === \App\Models\VoteType::NO,
            ])>{{ $voteType->value }}</span>@if(!$userArgument)
                Next, give your arguments:
            @else
                !
            @endif
        </div>
    @endif

    @if(!$userArgument && $voteType)
        <div class="flex {{ $voteType->getJustify() }} mt-6">
            <div class="
                flex-1
                p-4 flex gap-4
                items-end
                {{ $voteType->getJustify() }}
                bg-white
            border-gray-200
            @if ($voteType === \App\Models\VoteType::YES)
                border-l-green-400
                border-l-8
                md:mr-8
            @else
                border-r-red-400
                border-r-8
                md:ml-8
            @endif
            shadow-md
            p-4 gap-4 items-center
        ">
                <div class="w-full">
                    <small>
                        Your argument:
                    </small>

                    <div class="grid gap-2">
                        <x-markdown-editor
                            wire:model="body"
                            class="
                                w-full border border-{{ $voteType->getColor() }}-200
                                active:border-{{ $voteType->getColor() }}-400
                                rounded
                               "
                        />
                        @error('body')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <button
                        type="submit"
                        class="
                            font-bold
                            class='
                            @if(empty($this->body))
                             cursor-not-allowed
                            @else
                            cursor-pointer
                            hover:bg-{{ $voteType->getColor() }}-600
                            @endif
                            py-2 px-4
                            bg-{{ $voteType->getColor() }}-400
                            text-white
                            text-center
                            rounded-full
                        "
                        wire:click="storeArgument"
                    >Submit
                    </button>

                    <button class="
                        bg-gray-100
                        hover:bg-gray-200
                        py-2 px-4
                        text-center
                        rounded-full
                    " wire:click="cancel">Cancel</button>
                </div>
            </div>
        </div>
    @endif
</div>
