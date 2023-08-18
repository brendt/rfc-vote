@php
    /**
     * @var Illuminate\View\ComponentAttributeBag $attributes
     * @var string $slot
     */

    $styles = 'bg-purple-800 hover:bg-purple-900 inline-flex gap-3 px-4 py-2 px-4 transition-colors rounded-md font-bold text-white';
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
