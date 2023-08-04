<div>

    <div class="border-gray-700 border-2 flex shadow-xl font-bold font-mono">
        <div
            class="
                p-4 flex-grow text-left border-r border-gray-700 hover:bg-green-600 hover:text-white cursor-pointer
                min-w-[15%]
                @if($user?->getVoteForRfc($rfc)?->type === \App\Models\VoteType::YES)
                bg-green-600 text-white
                @else
                bg-green-200 text-green-900
                @endif
            "
            style="width: {{ $rfc->percentage_yes }}%;"
            @if($user?->getVoteForRfc($rfc)?->type === \App\Models\VoteType::YES)
                wire:click="undo()"
            @else
                wire:click="vote('{{ \App\Models\VoteType::YES }}')"
            @endif
        >
            {{ $rfc->percentage_yes }}%
        </div>
        <div
            class="
                p-4 flex-grow text-right border-l border-gray-700  hover:bg-red-600 hover:text-white cursor-pointer
                min-w-[15%]

                @if($user?->getVoteForRfc($rfc)?->type === \App\Models\VoteType::NO)
                bg-red-600 text-white
                @else
                bg-red-200 text-red-900
                @endif
            "
            style="width: {{ $rfc->percentage_no }}%;"
            @if($user?->getVoteForRfc($rfc)?->type === \App\Models\VoteType::NO)
                wire:click="undo()"
            @else
                wire:click="vote('{{ \App\Models\VoteType::NO }}')"
            @endif >
            {{ $rfc->percentage_no }}%
        </div>
    </div>

    <div class="flex justify-between p-2 px-4 font-bold text-sm">
        <div>{{ $rfc->count_yes }} {{ \Illuminate\Support\Str::plural('vote', $rfc->count_yes) }}</div>
        <div>{{ $rfc->count_no }} {{ \Illuminate\Support\Str::plural('vote', $rfc->count_no) }}</div>
    </div>

</div>
