@php
    /** @var \App\Models\Argument $argument */
@endphp

<div
    class="
        {{ $user?->can('vote', $argument) ?  "cursor-pointer" : "cursor-not-allowed" }}
        flex flex-col gap-1 transition-colors py-3 px-2 mb-5 max-w-[50px] mx-auto text-center rounded-2xl text-lg border border-transparent box-content
        @if ($argument->vote_type->isYes())
            text-agree-arrow
            bg-agree-arrow-background
            border-green-300
            {{ $argument->user()->is($user) ? '' : 'hover:border-agree-arrow-border hover:text-agree-arrow-hover' }}
        @else
            text-disagree-arrow
            bg-disagree-arrow-background
            border-red-300
            {{ $argument->user()->is($user) ? '' : 'hover:border-disagree-arrow-border hover:text-disagree-arrow-hover' }}
        @endif
    "
    wire:click="voteForArgument({{ $argument->id }})"
>
    @if ($user?->hasVotedForArgument($argument))
        <span wire:loading.remove wire:target="voteForArgument({{ $argument->id }})">
            <x-icons.arrow-up-filled class="w-8 h-8 text-black m-auto text-inherit"></x-icons.arrow-up-filled>
        </span>
        <span wire:loading wire:target="voteForArgument({{ $argument->id }})">
             <x-icons.loading  class="w-8 h-8 text-black m-auto text-inherit"></x-icons.loading>
        </span>
    @elseif($user?->can('vote', $argument))
        <span wire:loading.remove wire:target="voteForArgument({{ $argument->id }})">
            <x-icons.arrow-up-empty  class="w-8 h-8 text-black m-auto text-inherit"></x-icons.arrow-up-empty>
        </span>
        <span wire:loading wire:target="voteForArgument({{ $argument->id }})">
             <x-icons.loading  class="w-8 h-8 text-black m-auto text-inherit"></x-icons.loading>
        </span>
    @endif

    <span class="font-bold w-8">{{ $argument->vote_count }}</span>
</div>
