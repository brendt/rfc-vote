<div>
    @if (!$userVote)
        <div class="font-bold mb-3 flex justify-center">
            Click the bar to cast your vote!
        </div>
    @endif

    <div class="flex shadow-xl font-bold rounded-full overflow-hidden">
        <div
            class="
                    p-4 flex-grow text-left hover:bg-green-600 hover:text-white cursor-pointer
                    min-w-[15%]
                    @if($userVote?->type === \App\Models\VoteType::YES)
                    bg-green-600 text-white
                    @else
                    bg-green-300 text-green-900
                    @endif
                "
            style="width: {{ $rfc->percentage_yes }}%;"
            @if($userVote?->type === \App\Models\VoteType::YES)
                wire:click="undo()"
            @else
                wire:click="vote('{{ \App\Models\VoteType::YES }}')"
            @endif
        >
            {{ $rfc->percentage_yes }}%
        </div>
        <div
            class="
                    p-4 flex-grow text-right hover:bg-red-600 hover:text-white cursor-pointer
                    min-w-[15%]

                    @if($userVote?->type === \App\Models\VoteType::NO)
                    bg-red-600 text-white
                    @else
                    bg-red-300 text-red-900
                    @endif
                "
            style="width: {{ $rfc->percentage_no }}%;"
            @if($userVote?->type === \App\Models\VoteType::NO)
                wire:click="undo()"
            @else
                wire:click="vote('{{ \App\Models\VoteType::NO }}')"
            @endif >
            {{ $rfc->percentage_no }}%
        </div>
    </div>

    @if($userVote)
        <div class="flex justify-center mt-3 font-bold items-baseline gap-1">
            You've voted&nbsp;<span @class([
                'p-1 px-3 rounded-full text-white shadow-md',
                'bg-green-500' => $userVote->type === \App\Models\VoteType::YES,
                'bg-red-500' => $userVote->type === \App\Models\VoteType::NO,
            ])>{{ $userVote->type->value }}</span>@if(!$userArgument) Don't forget to leave your arguments:@else!@endif
        </div>
    @endif
</div>
