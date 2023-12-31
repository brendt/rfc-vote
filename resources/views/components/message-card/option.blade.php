@php
    /**
     * @var Illuminate\View\ComponentAttributeBag $attributes
     * @var Illuminate\View\ComponentSlot $slot
     */

    $styles = 'px-4 py-2 block text-[.9rem] hover:bg-purple-100 dark:hover:bg-main-light w-full text-left flex gap-2 items-center';
@endphp

@if ($attributes->has('href'))
    <a {{ $attributes->merge(['class' => $styles]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => 'button', 'class' => $styles]) }}>
        {{ $slot }}
    </button>
@endif
