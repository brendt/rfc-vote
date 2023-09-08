@php
    /**
     * @var string $to
     * @var App\Models\VoteType|null $userVote
     */

    $flexDirection = str_contains($attributes->get('class', ''), 'flex-row') ? '' : 'flex-col';
@endphp

<div {{dusk('card-link')}} class="{{ $flexDirection }} bg-rfc-card transition-all opacity-90 rounded-lg border border-divider flex justify-between gap-2 p-3 md:p-7 flex-1">
    {{ $slot }}

    <div class="flex items-center justify-between mt-2">
        <small>
            @isset($userVote)
                <x-tag @class([
                    'bg-none pl-1 pr-0',
                    'text-agree' => $userVote->isYes(),
                    'text-disagree' => $userVote->isNo(),
                ])>
                    {{ __('You voted') }} {{ $userVote->value }}
                </x-tag>
            @endisset
        </small>

        <a
            {{dusk('card-link-more')}}
            href="{{ $to }}"
            title="Navigate to the RFC"
            class="text-main hover:text-main-dark dark:text-font dark:hover:text-font-second transition-colors"
        >
            Read more
        </a>
    </div>
</div>
