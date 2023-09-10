@php
    /**
     * @var Illuminate\View\ComponentAttributeBag $attributes
     */
@endphp

<button
    {{ $attributes->merge([
        'type' => 'button',
        'class' => 'p-1 rounded-full group-hover:bg-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors',
    ]) }}
>
    <x-icons.ellipsis-vertical class="w-7 h-7 text-font" />
</button>