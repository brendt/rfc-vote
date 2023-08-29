@php
    /**
     * @var Illuminate\View\ComponentSlot $slot
     * @var string|null $url
     */
@endphp

@if ($url)
    <a
        href="{{ $url }}"
        target="_blank"
        rel="noopener noreferrer"
        class="hover:opacity-70 transition-opacity fill-font text-font"
    >
        {{ $slot }}
    </a>
@endif
