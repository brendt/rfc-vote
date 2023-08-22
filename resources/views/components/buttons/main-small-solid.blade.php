@php
    /**
     * @var Illuminate\View\ComponentAttributeBag $attributes
     * @var Illuminate\View\ComponentSlot $slot
     */

    $styles = 'bg-none hover:bg-purple-50 hover:text-gray-700 hover:border-gray-600 inline-flex items-center justify-center gap-2 px-2 py-1 transition-colors rounded-md border border-main-light font-bold text-sm cursor-pointer text-main-dark';
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
