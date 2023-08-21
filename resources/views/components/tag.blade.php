@php
    /**
     * @var Illuminate\View\ComponentAttributeBag $attributes
     */

    $bg = str_contains($attributes->get('class', ''), 'bg-') ? '' : 'bg-gray-200';
    $commonStyles = "{$bg} py-1 px-2.5 rounded-full flex items-end gap-1 shadow-sm opacity-90 font-bold uppercase border border-transparent";
@endphp

@if ($attributes->has('href'))
    <a {{ $attributes->merge(['class' => "{$commonStyles} hover:shadow-sm transition-all hover:opacity-100 hover:border-gray-400"]) }}>
        {{ $slot }}
    </a>
@else
    <div {{ $attributes->merge(['class' => $commonStyles]) }}>
        {{ $slot }}
    </div>
@endif

