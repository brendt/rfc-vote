@php
    /**
     * @var App\Models\Argument $argument
     * @var App\Models\User|null $user
     */
@endphp

<div class="flex gap-4 items-center justify-end py-4 pr-4 text-gray-500 opacity-90">
    {{-- Label that shows when argument has been created --}}
    <small>
        {{ __('Created') }} {{ $argument->created_at->diffForHumans() }}
    </small>

    {{-- Label that shows if the argument has been seen --}}
    @if ($user && $user->hasSeenArgument($argument))
        <small class="flex gap-1.5 items-center">
            <x-icons.eye class="w-4 h-4" />
            <span>{{ __('Seen') }}</span>
            <x-icons.check class="w-4 h-4" />
        </small>
    @endif
</div>
