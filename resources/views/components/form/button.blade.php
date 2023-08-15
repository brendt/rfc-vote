@php
    /**
     * @var string $slot
     * @var Illuminate\View\ComponentAttributeBag $attributes
     */
@endphp

<x-buttons.main {{ $attributes->merge([]) }}>{{ $slot }}</x-buttons.main>
