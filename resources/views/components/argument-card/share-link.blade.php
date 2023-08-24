@php
    /**
     * @var Illuminate\View\ComponentAttributeBag $attributes
     * @var string $icon
     */
@endphp

<a {{ $attributes }}>
    <x-dynamic-component
        :component="$icon"
        class="w-5 h-5 opacity-60 hover:opacity-100 transition-opacity"
    />
</a>

