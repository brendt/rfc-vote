@php
    /**
     * @var boolean $isActive
     * @var Illuminate\View\ComponentAttributeBag $attributes
     */
@endphp

<a
    {{ $attributes->merge([
        'class' => 'text-white px-4 py-2 ' . ($isActive ? 'bg-purple-800' : 'hover:bg-black')
    ]) }}
>
    {{ $slot }}
</a>
