<div>

    <div class="border-gray-700 border-4 flex rounded shadow-xl font-bold font-mono">
        <div
            class="
                p-4 flex-grow text-left border-r-2 border-gray-700 hover:bg-green-600 hover:text-white cursor-pointer
                min-w-[10%]
                @if($user?->getVoteForRfc($rfc)?->type === \App\Models\VoteType::YES)
                bg-green-600 text-white
                @else
                bg-green-200 text-green-900
                @endif
            "
            style="width: {{ $rfc->percentage_yes }}%;"
            wire:click="vote('{{ \App\Models\VoteType::YES }}')"
        >
            {{ $rfc->percentage_yes }}% <small>({{ $rfc->count_yes }})</small>
        </div>
        <div
            class="
                p-4 flex-grow text-right border-l-2 border-gray-700  hover:bg-red-600 hover:text-white cursor-pointer
                min-w-[10%]

                @if($user?->getVoteForRfc($rfc)?->type === \App\Models\VoteType::NO)
                bg-red-600 text-white
                @else
                bg-red-200 text-red-900
                @endif
            "
            style="width: {{ $rfc->percentage_no }}%;"
            wire:click="vote('{{ \App\Models\VoteType::NO }}')"
        >
            {{ $rfc->percentage_no }}% <small>({{ $rfc->count_no }})</small>
        </div>
    </div>

</div>
