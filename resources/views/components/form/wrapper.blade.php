@php
    /**
     * @var string $slot
     * @var string|null $heading
     * @var Illuminate\View\ComponentAttributeBag $attributes
     */
@endphp

<form {{ $attributes->merge(['class' => 'bg-white mx-3 md:mx-0 p-8 rounded-lg shadow-md dark:bg-secondary-dark-mode dark:text-black']) }}>
    @csrf

    @isset($heading)
        <h2 class="text-2xl font-bold text-gray-700 mb-4 dark:text-white">{{ $heading }}</h2>
    @endisset

    {{ $slot }}
</form>
