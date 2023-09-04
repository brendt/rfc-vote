@php
    /**
     * @var Illuminate\View\ComponentAttributeBag $attributes
     * @var Illuminate\View\ComponentSlot $slot
     */

    $styles = 'bg-purple-800 inline-flex items-center gap-3 py-2.5 px-6 transition-colors rounded-md font-bold text-white ';
    $styles .= $attributes->get('disabled') === true ? 'opacity-50 cursor-not-allowed' : 'hover:bg-purple-900 cursor-pointer';
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
