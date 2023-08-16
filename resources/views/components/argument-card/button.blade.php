@php
    /**
     * @var Illuminate\View\ComponentAttributeBag $attributes
     */
    $styles = 'px-5 py-1 text-[.9rem] rounded-full font-bold text-gray-900 transition-colors border';
@endphp

@if ($attributes->has('href'))
    <a {{ $attributes->merge(['class' => $styles]) }}>
        <span class="flex items-center gap-2 justify-center">
            <x-dynamic-component :component="$icon" class="w-4 h-4"/> {{ $slot }}
        </span>
    </a>
@else
    <button {{ $attributes->merge(['class' => $styles]) }}>
        <span class="flex items-center gap-2 justify-center">
            <x-dynamic-component :component="$icon" class="w-4 h-4"/> {{ $slot }}
        </span>
    </button>
@endif
