@php
    /**
     * @var Illuminate\View\ComponentAttributeBag $attributes
     * @var Illuminate\View\ComponentSlot $slot
     */

    $styles = 'px-3 py-2 block text-[.95rem] hover:bg-purple-100 w-full text-left';
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
