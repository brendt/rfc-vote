@php
    /**
     * @var string $to
     */

    $flexDirection = str_contains($attributes->get('class', ''), 'flex-row') ? '' : 'flex-col';
@endphp

<div class="{{ $flexDirection }} bg-rfc-card transition-all opacity-90 rounded-lg border border-divider flex justify-between gap-2 p-3 md:p-7">
    {{ $slot }}

    <div class="text-right mt-2">
        <a
            href="{{ $to }}"
            title="Navigate to the RFC"
            class="text-main hover:text-main-dark dark:text-font dark:hover:text-font-second transition-colors"
        >
            Read more
        </a>
    </div>
</div>
