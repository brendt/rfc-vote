@php
    /**
     * @var string $slot
     * @var string|null $heading
     * @var Illuminate\Support\ViewErrorBag $errors
     */
@endphp

<form {{ $attributes->merge(['class' => 'bg-white p-6 rounded-lg shadow-md']) }}>
    @isset($heading)
        <h2 class="text-2xl font-bold text-gray-700">{{ $heading }}</h2>
    @endisset

    {{ $slot }}
</form>
