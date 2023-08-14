@php
    /**
     * @var string $slot
     * @var Illuminate\View\ComponentAttributeBag $attributes
     */
@endphp

<button {{ $attributes->merge(['class' => 'bg-purple-800 text-white rounded-md px-5 py-2 mt-3 shadow-md transition-all hover:bg-purple-900 hover:shadow-lg']) }}>
    {{ $slot }}
</button>
