@php
    /**
     * @var boolean $isActive
     * @var Illuminate\View\ComponentAttributeBag $attributes
     */
@endphp

<a
    {{ $attributes->merge([
        'class' => 'text-white px-3 py-1 ' . ($isActive ? '' : '')
    ]) }}
>
    {{ $slot }}
</a>
