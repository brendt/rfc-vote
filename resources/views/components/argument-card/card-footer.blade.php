@php
    /**
     * @var App\Models\Argument $argument
     * @var App\Models\User|null $user
     * @var string $anchorLink
     */
@endphp

<div class="flex flex-col lg:flex-row gap-4 items-center justify-between mb-3 mt-1 opacity-90">
    <x-argument-card.share-links :argument="$argument" :anchor-link="$anchorLink" />

    <div class="flex gap-4 items-center">
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
</div>
