@php
    /**
     * @var Illuminate\View\ComponentSlot $slot
     * @var Illuminate\View\ComponentAttributeBag $attributes
     */
@endphp

@if ($slot->isNotEmpty())
    <div role="alert" {{ $attributes->merge(['class' => 'mb-5 bg-blue-100 border border-blue-200 rounded-lg py-5 px-7']) }}>
        {{ $slot }}
    </div>
@endif
