@php
    /**
     * @var Illuminate\View\ComponentAttributeBag $attributes
     * @var Illuminate\View\ComponentSlot $slot
     */
@endphp

<h2 {{dusk('title')}} {{ $attributes->merge(['class' => 'text-2xl text-font-second font-bold tracking-wide mt-2 md:mb-1']) }}>
    {{ $slot }}
</h2>
