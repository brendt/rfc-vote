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
                'bg-green-600 text-white' => $voteType === App\Models\VoteType::YES,
                'bg-green-300 text-green-900' => $voteType !== App\Models\VoteType::YES,
            ])
            style="width: {{ $rfc->percentage_yes }}%;"

            @if(! $hasVoted)
                wire:click="vote('{{ App\Models\VoteType::YES }}')"
            @endif
        >
            {{ $rfc->percentage_yes }}%
        </div>

        <div
            @class([
                'p-4 flex-grow text-right md:min-w-[15%]min-w-[20%]',
                'hover:bg-red-600 hover:text-white cursor-pointer' => ! $hasVoted,
                'bg-red-600 text-white' => $voteType === App\Models\VoteType::NO,
                'bg-red-300 text-red-900' => $voteType !== App\Models\VoteType::NO,
            ])
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
                'bg-green-500' => $voteType === App\Models\VoteType::YES,
                'bg-red-500' => $voteType === App\Models\VoteType::NO,
            ])>{{ $voteType->value }}</span>@if(!$userArgument)
                Next, give your arguments:
            @else
                !
            @endif
        </div>
    @endif

    @if(!$userArgument && $voteType)
        <div class="flex {{ $voteType->getJustify() }} mt-6">
            <div @class([
                'flex-1 p-4 flex gap-4 items-end bg-white border-gray-200 shadow-md p-4 gap-4 items-center',
                $voteType->getJustify(),
                'border-l-green-400 border-l-8 md:mr-8' => $voteType === App\Models\VoteType::YES,
                'border-r-red-400 border-r-8 md:ml-8' => $voteType !== App\Models\VoteType::YES,
            ])>
                <div class="w-full">
                    <small>Your argument:</small>

                    <div class="grid gap-2">
                        <x-markdown-editor
                            wire:model="body"
                            @class([
                                'rounded w-full border',
                                'border-green-200 active:border-green-200' => $voteType->getColor() === 'green',
                                'border-red-200 active:border-red-200' => $voteType->getColor() === 'red',
                           ])
                        />

                        @error('body')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <button
                        type="submit"
                        @class([
                            'font-bold py-2 px-4 text-white text-center rounded-full',
                            'cursor-not-allowed' => empty($this->body),
                            'cursor-pointer hover:bg-green-600' => ! empty($this->body) && $voteType->getColor() === 'green',
                            'cursor-pointer hover:bg-red-600' => ! empty($this->body) && $voteType->getColor() === 'red',
                            'bg-green-400' => $voteType->getColor() === 'green',
                            'bg-red-400' => $voteType->getColor() === 'red',

                        ])
                        wire:click="storeArgument"
                    >
                        Submit
                    </button>

                    <button
                        class="bg-gray-100 hover:bg-gray-200 py-2 px-4 text-center rounded-full"
                        wire:click="cancel"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
