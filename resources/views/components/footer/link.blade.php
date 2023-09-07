@php
    /**
     * @var Illuminate\View\ComponentAttributeBag $attributes
     * @var Illuminate\View\ComponentSlot $slot
     * @var string $icon
     */
@endphp

<a {{ $attributes->merge([
    'class' => 'group flex flex-col justify-center items-center gap-3',
    'target' => '_blank'
]) }}>
    <x-dynamic-component :component="$icon" class="w-10 h-10 fill-white dark:opacity-80 transition-all group-hover:scale-110 group-hover:opacity-100" />
    <small>{{ $slot }}</small>
</a>
