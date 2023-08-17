@php
    /**
     * @var Illuminate\View\ComponentAttributeBag $attributes
     * @var string $icon
     */
@endphp

<a {{ $attributes }}>
    <x-dynamic-component
        :component="$icon"
        class="w-5 h-5 text-gray-400 hover:text-gray-500 transition-colors"
    />
</a>

