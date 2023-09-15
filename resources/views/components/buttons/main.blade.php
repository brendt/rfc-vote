@php
    /**
     * @var Illuminate\View\ComponentAttributeBag $attributes
     * @var Illuminate\View\ComponentSlot $slot
     */

    $styles = 'bg-main-light hover:bg-main border border-transparent dark:border-divider inline-flex items-center gap-3 py-2 px-4 transition-colors rounded-md font-bold text-white dark:text-gray-200 cursor-pointer';
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
