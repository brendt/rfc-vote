@php
    /**
     * @var Illuminate\View\ComponentAttributeBag $attributes
     * @var Illuminate\View\ComponentSlot $slot
     */
@endphp

<a {{ $attributes->merge(['class' => 'px-3 py-2 block text-[.95rem] hover:bg-purple-100']) }}>
    {{ $slot }}
</a>
