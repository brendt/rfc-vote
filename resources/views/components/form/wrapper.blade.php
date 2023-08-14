@php
    /**
     * @var string $slot
     * @var string|null $heading
     * @var Illuminate\View\ComponentAttributeBag $attributes
     */
@endphp

<form {{ $attributes->merge(['class' => 'bg-white p-6 rounded-lg shadow-md']) }}>
    @csrf

    @isset($heading)
        <h2 class="text-2xl font-bold text-gray-700 mb-4">{{ $heading }}</h2>
    @endisset

    {{ $slot }}
</form>
