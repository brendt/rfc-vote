<div>
    @if (!$voteType)
        <div class="mb-3 text-gray-600 tracking-wide flex gap-2 items-center justify-center">
            <x-icons.information-circle class="w-6 h-6" />
            @lang('Click the bar to cast your vote!')
        </div>
    @endif

    <div class="flex shadow-lg font-bold rounded-full overflow-hidden p-1.5 lg:p-3 bg-gray-200 max-w-[1100px] mx-auto">
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
                'py-1.5 lg:py-3 px-6 flex-grow text-right md:min-w-[15%] min-w-[20%] rounded-r-full bg-gradient-to-r from-disagree to-disagree-light text-white hover:opacity-100',
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
            <span class="text-gray-600 tracking-wide">
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
                'flex-1 p-5 flex flex-col items-end rounded-lg bg-white border-gray-200 shadow-md p-4 gap-3 md:gap-2',
                $voteType->getJustify(),
            ])>
                <div class="w-full">
                    <p class="mb-1 text-gray-600">@lang('Your argument'):</p>

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

                <div class="flex gap-2">
                    <x-buttons.main
                        type="submit"
                        wire:click="storeArgument"
                        @class([
                            'cursor-not-allowed' => empty($this->body),
                            'cursor-pointer' => !empty($this->body),
                            '!bg-agree hover:!bg-agree-dark' => $voteType->getColor() === 'green',
                            '!bg-disagree hover:!bg-disagree-dark' => $voteType->getColor() === 'red',
                        ])
                    >
                        <span wire:loading wire:target="storeArgument">
                             <x-icons.loading class="w-6 h-6" />
                        </span>
                        <span wire:loading.remove wire:target="storeArgument">
                            <x-icons.check class="w-6 h-6" />
                        </span>

                        @lang('Submit')
                    </x-buttons.main>

                    <x-buttons.ghost wire:click="cancel">
                        <x-icons.cancel class="w-6 h-6" />
                        @lang('Cancel')
                    </x-buttons.ghost>
                </div>
            </div>
        </div>
    @endif
</div>
