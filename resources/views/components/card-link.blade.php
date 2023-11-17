@php
    /**
     * @var string $to
     * @var App\Models\VoteType|null $userVote
     */

    $flexDirection = str_contains($attributes->get('class', ''), 'flex-row') ? '' : 'flex-col';
@endphp

<div {{dusk('card-link')}} class="{{ $flexDirection }} bg-rfc-card transition-all opacity-90 rounded-lg border border-divider flex justify-between gap-2 p-3 md:p-7 flex-1">
    {{ $slot }}

    <div class="flex items-center justify-between mt-5">
        <small>
            @isset($userVote)
                <x-tag @class([
                    'bg-none pl-1 pr-0',
                    'text-agree' => $userVote->isYes(),
                    'text-disagree' => $userVote->isNo(),
                ])>
                    You voted {{ $userVote->value }}
                </x-tag>
            @endisset
        </small>

        <a
            {{dusk('card-link-more')}}
            href="{{ $to }}"
            title="Navigate to the RFC"
            @class([
                'flex text-font items-center gap-2 bg-slate-100 border border-slate-200 px-4 pr-2 py-1.5 rounded-full',
                'dark:bg-gray-800 dark:border-slate-600 dark:hover:border-slate-400',
                'group transition-colors hover:border-slate-400 dark:hover:bg-background',
            ])
        >
            Read more

            <x-icons.arrow-up-empty @class([
                'w-6 h-6 inline-block rotate-90 text-slate-700 dark:text-slate-300 transition-transform',
                'group-hover:dark:text-slate-200 group-hover:text-slate-900 group-hover:scale-110',
            ]) />
        </a>
    </div>
</div>
