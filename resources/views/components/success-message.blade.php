@php
    /**
     * @var Illuminate\View\ComponentSlot $slot
     * @var Illuminate\View\ComponentAttributeBag $attributes
     */
@endphp

@if ($slot->isNotEmpty())
    <div role="alert" {{ $attributes->merge(['class' => 'mb-5 bg-info border border-blue-200 dark:border-transparent rounded-lg py-5 px-7 text-font']) }}>
        {{ $slot }}
    </div>
@endif
