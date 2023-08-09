@php
$flexDirection = '';

if (!str_contains($attributes->get('class'), 'flex-row')) {
    $flexDirection = 'flex-col';
}
@endphp

<div
    {{ $attributes->merge([
        'class' => "
            border-gray-200 border
            bg-white
            rounded
            shadow-md
            flex {$flexDirection} items-center justify-between gap-2
            p-4 md:pt-8 md:px-6
            "
    ]) }}>

    {{ $slot }}
</div>
