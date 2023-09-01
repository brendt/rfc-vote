@php
    /**
     * @var Illuminate\View\ComponentAttributeBag $attributes
     * @var Illuminate\View\ComponentSlot $slot
     */
@endphp

<a {{ $attributes->merge(['class' => 'underline']) }}>{{ $slot }}</a>
