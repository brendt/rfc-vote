@php
    $bg = '';

    if (!str_contains($attributes->get('class', ''), 'bg-')) {
        $bg = 'bg-gray-300';
    }
@endphp

<div {{ $attributes->merge([
    'class' => "{$bg} px-2 p-1 rounded-full flex items-end gap-1"
]) }}>
    {{ $slot }}
</div>
