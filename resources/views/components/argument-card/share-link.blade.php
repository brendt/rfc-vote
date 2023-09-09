@php
    /**
     * @var Illuminate\View\ComponentAttributeBag $attributes
     * @var string $icon
     * @var string $tip
     */
@endphp

<a {{ $attributes }} data-tippy-content="{{ $tip }}">
    <x-dynamic-component
        :component="$icon"
        class="w-5 h-5 opacity-60 hover:opacity-100 transition-opacity"
    />
</a>

