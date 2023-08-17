@php
    /**
     * @var App\Models\Argument $argument
     * @var App\Models\User|null $user
     * @var string $anchorLink
     */
@endphp

<div class="flex flex-col lg:flex-row gap-4 items-center justify-between mb-3 mt-1 opacity-80 border-t pt-3">
    <x-argument-card.share-links :argument="$argument" :anchor-link="$anchorLink" />

    <div class="flex flex-col md:flex-row gap-1 md:gap-3 items-center">
        <small class="flex items-center gap-1">
            @if ($user?->getAvatarUrl())
                <a
                    href="{{ action(App\Http\Controllers\PublicProfileController::class, $user) }}"
                    class="flex items-center gap-1.5 group/username"
                >
                    <img
                        src="{{ $user->getAvatarUrl() }}"
                        class="rounded-full shadow-sm w-[20px] h-[20px]"
                        alt="{{ $user->username }} avatar"
                    />

                    <span class="group-hover/username:underline">{{ $user->username }}</span>
                </a>
            @endif

            {{ __('voted') }}

            <b @class([
                'tracking-wide uppercase',
                'text-green-700' => $argument->vote_type->isYes(),
                'text-red-700' => $argument->vote_type->isNo(),
            ])>
                {{ $argument->vote_type->value }}
            </b>
        </small>

        <span class="hidden md:block">•</span>

        {{-- Label that shows when argument has been created --}}
        <small title="{{ __('Argument creation date') }}">
            <span class="md:hidden">{{ __('Created') }}</span>
            {{ $argument->created_at->diffForHumans() }}
        </small>

        {{-- Label that shows if the argument haven't been seen --}}
        @if ($user && !$user->hasSeenArgument($argument))
            <span class="hidden md:block">•</span>
            <small class="flex gap-1.5 items-center">
                <x-icons.check-badge class="w-4 h-4" />
                <span>{{ __('New') }}</span>
            </small>
        @endif
    </div>
</div>
