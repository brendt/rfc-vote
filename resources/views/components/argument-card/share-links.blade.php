@php
    /**
     * @var App\Models\Argument $argument
     * @var string $anchorLink
     */
@endphp

<div class="flex flex-col gap-3 group-hover:opacity-100 opacity-0 duration-300 transition-opacity">
    <x-argument-card.share-link
        href="{{ '#' . $anchorLink }}"
        title="{{ __('Copy the ') }}"
        icon="icons.link"
    />

    <x-argument-card.share-link
        :href="'https://x.com/intent/tweet?text=PHP RFC Votes for ' . urlencode($argument->rfc->title) . '&url=' . urlencode(url()->current())"
        target="_blank"
        title="{{ __('Share on X') }}"
        icon="icons.x"
    />

    <x-argument-card.share-link
        :href="'https://www.linkedin.com/sharing/share-offsite/?url=PHP RFC Votes for '  . url()->current()"
        target="_blank"
        title="{{ __('Share on LinkedIn') }}"
        icon="icons.linkedin"
    />
</div>
