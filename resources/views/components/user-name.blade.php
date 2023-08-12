@php
    /**
     * @var \App\Models\Argument $argument
     */
@endphp

<span class="flex items-center gap-3 relative group">
    <span
        class="
            font-bold
            {{ $argument->vote_type->getColor() === 'green' ? 'text-green-700' : 'text-red-700' }}
            border
            border-gray-400
            rounded-lg
            px-4
            relative
            mr-1
        "
    >
        {{ $argument->vote_type === \App\Models\VoteType::YES ? 'Yes' : 'No' }}!

        {{-- dialog corner to the right --}}
        <div class="absolute w-2 h-2 bg-white border-r border-t border-gray-400 right-[-5px] top-1/2 -translate-y-1/2 rotate-45"></div>
    </span>

    @if ($argument->user->getAvatarUrl())
        <img src="{{ $argument->user->getAvatarUrl() }}" class="rounded-full shadow-sm w-[30px] h-[30px]"/>
    @endif

    {{ $argument->user->name }} <x-user-popup :user="$argument->user"/>
</span>
