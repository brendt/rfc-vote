@php
    /**
     * @var Illuminate\View\ComponentAttributeBag $attributes
     */

    $bg = str_contains($attributes->get('class', ''), 'bg-') ? '' : 'bg-gray-200';
@endphp

<div {{ $attributes->merge([
    'class' => "{$bg} py-1 px-2.5 rounded-full flex items-end gap-1 shadow-sm hover:shadow-md transition-all opacity-90 hover:opacity-100"
]) }}>
    {{ $slot }}
</div>
