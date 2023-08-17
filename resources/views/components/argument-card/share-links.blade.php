@php
    /**
     * @var App\Models\Argument $argument
     * @var string $anchorLink
     */
@endphp

<div class="flex flex-col gap-3 group-hover:opacity-100 opacity-0 transition-opacity">
    <x-argument-card.share-link
        href="{{ '#' . $anchorLink }}"
        title="{{ __('Copy the ') }}"
        icon="icons.link"
    />
</div>
