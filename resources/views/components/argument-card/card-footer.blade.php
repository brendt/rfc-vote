@php
    /**
     * @var App\Models\Argument $argument
     * @var App\Models\User|null $user
     * @var string $anchorLink
     */

    $argumentUser = $argument->user;
@endphp

<div class="flex flex-col lg:flex-row gap-4 items-center justify-between mb-3 mt-1 opacity-80 border-divider divide-divider border-t pt-3">
    <x-argument-card.share-links :argument="$argument" :anchor-link="$anchorLink" />

    <div class="flex flex-col md:flex-row gap-1 md:gap-3 items-center">
        @if($readonly)
            <span class="text-xs">
                Read the RFC: <a href="{{ action(\App\Http\Controllers\RfcDetailController::class, $argument->rfc) }}" class="underline hover:no-underline">{{ $argument->rfc->title }}</a>
            </span>

            <span class="hidden md:block">•</span>
        @endif

{{--        <span class="text-xs cursor-pointer" wire:click="openComments({{ $argument->id }})">--}}
{{--            {{ $argument->comments->count() }} {{ Str::plural('comment', $argument->comments->count()) }}--}}
{{--        </span>--}}
{{----}}
{{--        <span class="hidden md:block">•</span>--}}

        <small class="flex items-center gap-1">
            <x-profile.username :user="$argumentUser" />

            {{ __('voted') }}

            <b @class([
                'tracking-wide uppercase ml-0.5',
                'text-agree' => $argument->vote_type->isYes(),
                'text-disagree' => $argument->vote_type->isNo(),
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
        @if (!$readonly && $user && !$user->hasSeenArgument($argument))
            <span class="hidden md:block">•</span>
            <small class="flex gap-1.5 items-center">
                <x-icons.check-badge class="w-4 h-4" />
                <span>{{ __('New') }}</span>
            </small>
        @endif
    </div>
</div>
