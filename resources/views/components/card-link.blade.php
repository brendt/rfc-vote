@php
    /**
     * @var Illuminate\View\ComponentAttributeBag $attributes
     */

    $flexDirection = str_contains($attributes->get('class', ''), 'flex-row') ? '' : 'flex-col';
@endphp

<a
    {{ $attributes->merge([
        'class' => "bg-rfc-card hover:drop-shadow-lg transition-all opacity-90 hover:opacity-100 rounded-lg shadow-md flex justify-between gap-2 p-4 md:p-7 {$flexDirection}"
    ]) }}
>
    {{ $slot }}
</a>
