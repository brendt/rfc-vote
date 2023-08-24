@php
    /**
     * @var Illuminate\View\ComponentAttributeBag $attributes
     * @var Illuminate\View\ComponentSlot $slot
     */

    $styles = 'px-4 py-3 block text-[.95rem] dark:hover:bg-main-light hover:bg-purple-100 w-full text-left flex gap-2 items-center';
@endphp

@if ($attributes->has('href'))
    <a {{ $attributes->merge(['class' => $styles]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $styles, 'type' => 'button']) }}>
        {{ $slot }}
    </button>
@endif
