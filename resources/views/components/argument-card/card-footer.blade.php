@php
    use App\Models\Argument;
    use App\Models\User;
    use \App\Http\Controllers\RfcDetailController;

    /**
     * @var Argument $argument
     * @var User|null $user
     * @var string $anchorLink
     * @var bool $isRightSided
     */

    $argumentUser = $argument->user;
@endphp

<div
    @class([
        'flex flex-col gap-4 items-center justify-between mb-3 mt-1 opacity-80 border-divider border-t pt-3',
        'lg:flex-row' => !$isRightSided,
        'lg:flex-row-reverse' => $isRightSided,
    ])
>
    <x-argument-card.share-links :argument="$argument" :anchor-link="$anchorLink" />

    <div class="flex flex-col md:flex-row gap-1 md:gap-3 items-center">
        @if($readonly)
            <span class="text-xs">
                Read the RFC:

                <a
                    href="{{ action(RfcDetailController::class, $argument->rfc) }}"
                    class="underline hover:no-underline"
                >
                    {{ $argument->rfc->title }}
                </a>
            </span>

            <span class="hidden md:block">•</span>
        @endif

        <small class="flex items-center gap-1">
            <x-profile.username :user="$argumentUser" />

            voted

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
        <time datetime="{{ $argument->created_at->format('c') }}" title="{{ $argument->created_at->format('c') }}">
            <small>
                <span class="md:hidden">{{ __('Created') }}</span>
                {{ $argument->created_at->diffForHumans() }}
            </small>
        </time>
    </div>
</div>
