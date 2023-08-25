<div>
    @if (!$voteType)
        <div class="mb-3 text-gray-600 tracking-wide flex gap-2 items-center justify-center">
            <x-icons.information-circle class="w-6 h-6" />
            {{ __('Click the bar to cast your vote!') }}
        </div>
    @endif

    <div class="flex shadow-lg font-bold rounded-full overflow-hidden p-1.5 lg:p-3 bg-vote-bar-background dark:bg-secondary-dark-mode max-w-[1100px] mx-auto">
        {{-- Left (green) bar --}}
        <div
            @class([
                'py-1.5 lg:py-3 px-6 flex-grow text-left md:min-w-[15%] min-w-[20%] rounded-l-full bg-gradient-to-r from-agree to-agree-light text-white hover:opacity-100',
                'cursor-not-allowed opacity-100' => $hasVoted,
                'hover:bg-green-600 cursor-pointer opacity-80 shadow-md hover:shadow-[0px_0px_7px_var(--color-agree-light)]' => ! $hasVoted,
            ])
            style="width: {{ $rfc->percentage_yes }}%;"

            @if(! $hasVoted)
                wire:click="vote('{{ App\Models\VoteType::YES }}')"
            @endif
        >
            {{ $rfc->percentage_yes }}%
        </div>

        {{-- Right (red) bar --}}
        <div
            @class([
                'py-1.5 lg:py-3  px-6 flex-grow text-right md:min-w-[15%] min-w-[20%] rounded-r-full bg-gradient-to-r from-disagree to-disagree-light text-white hover:opacity-100',
                'cursor-not-allowed opacity-100' => $hasVoted,
                'hover:bg-red-600 cursor-pointer opacity-80 shadow-md hover:shadow-[0px_0px_7px_var(--color-disagree-light)]' => ! $hasVoted,
            ])
            style="width: {{ $rfc->percentage_no }}%;"

            @if(! $hasVoted)
                wire:click="vote('{{ App\Models\VoteType::NO }}')"
            @endif
        >
            {{ $rfc->percentage_no }}%
        </div>
    </div>

    @if($voteType)
        <div class="flex justify-center mt-5 items-center gap-1">
            <span class=" text-font tracking-wide">
                {{ $userArgument ? "You've voted" : "You're voting" }}
            </span>

            <span @class([
                'uppercase ml-1 font-black text-lg',
                'text-agree' => $voteType === App\Models\VoteType::YES,
                'text-disagree' => $voteType === App\Models\VoteType::NO,
            ])>
                {{ $voteType->value }}
            </span>

            {{ $userArgument ? '!' : '! Please, give your arguments below:' }}
        </div>
    @endif

    @if(!$userArgument && $voteType)
        <div class="flex {{ $voteType->getJustify() }} mt-6">
            <div @class([
                'flex-1 p-4 flex gap-4 items-end bg-black border-gray-200 shadow-md p-4 gap-4 items-center',
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
                        <span wire:loading wire:target="storeArgument">
                             <x-icons.loading  class="w-6 h-6"></x-icons.loading>
                        </span>
                        <span wire:loading.remove wire:target="storeArgument">
                            Submit
                        </span>
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
