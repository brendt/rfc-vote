@php
    /**
     * @var string $leading
     * @var Illuminate\View\ComponentSlot $slot
     * @var Illuminate\View\ComponentAttributeBag $attributes
     */
@endphp

<div {{ $attributes->merge(['class' => 'odd:bg-rfc-card even:bg-background py-16 text-font']) }}>
    <div class="container mx-auto max-w-3xl">
        <h2 class="text-3xl">{{ $heading }}</h2>

        <div class="[&>p]:mt-6 [&_a]:underline text-lg">
            {{ $slot }}
        </div>
    </div>
</div>
