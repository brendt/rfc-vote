@php
    /**
     * @var string $slot
     * @var string|null $heading
     * @var Illuminate\View\ComponentAttributeBag $attributes
     */
@endphp

<div>
    <form {{ $attributes->merge(['class' => 'bg-form mx-3 md:mx-0 p-8 rounded-lg shadow-md text-font']) }}>
        @csrf

        @isset($heading)
            <h2 class="text-2xl font-bold mb-4 text-font">{{ $heading }}</h2>
        @endisset

        {{ $slot }}
    </form>
</div>
