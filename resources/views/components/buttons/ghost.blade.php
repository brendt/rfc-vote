@php
    /**
     * @var Illuminate\View\ComponentAttributeBag $attributes
     * @var Illuminate\View\ComponentSlot $slot
     */

    $styles = 'border border-gray-800 hover:bg-gray-100 inline-flex items-center gap-3 py-2 px-4 transition-colors rounded-md font-bold text-gray-900 hover:text-black hover:border-black cursor-pointer';
@endphp

@if ($attributes->has('href'))
    <a {{ $attributes->merge(['class' => $styles]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $styles]) }}>
        {{ $slot }}
    </button>
@endif
