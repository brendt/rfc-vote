@php
    /**
     * @var boolean $isActive
     * @var Illuminate\View\ComponentAttributeBag $attributes
     */
@endphp

<a {{ $attributes->merge(['class' => 'relative group']) }}>
    {{ $slot }}

    <div
        class="
            absolute bottom-0 top-6 -left-1 -right-1
            transition-transform
            duration-300
            group-hover:opacity-100
            group-hover:translate-y-0
            h-1
            bg-purple-200
            rounded-full
            {{ $isActive ? 'opacity-100' : 'opacity-0 -translate-y-1' }}
        "
    ></div>
</a>
