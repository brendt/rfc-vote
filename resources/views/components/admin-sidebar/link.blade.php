@php
    /**
     * @var boolean $isActive
     * @var Illuminate\View\ComponentAttributeBag $attributes
     */
@endphp

<a
    {{ $attributes->merge([
        'class' => 'text-white px-4 w-72 py-3 flex gap-4 ' . ($isActive ? 'bg-purple-700' : 'hover:bg-black')
    ]) }}
>
    {{ $slot }}
</a>
