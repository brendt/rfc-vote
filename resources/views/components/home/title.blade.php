@php
    /**
     * @var Illuminate\View\ComponentAttributeBag $attributes
     * @var Illuminate\View\ComponentSlot $slot
     */
@endphp

<h2 {{ $attributes->merge(['class' => 'text-2xl text-gray-600 font-bold tracking-wide mt-2 md:mb-1']) }}>
    {{ $slot }}
</h2>
