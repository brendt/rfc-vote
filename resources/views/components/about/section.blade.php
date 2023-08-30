@php
    /**
     * @var string $leading
     * @var Illuminate\View\ComponentSlot $slot
     * @var Illuminate\View\ComponentAttributeBag $attributes
     */
@endphp

<div {{ $attributes->merge(['class' => 'odd:bg-rfc-card even:bg-background py-12 md:py-16 px-5 lg:px-0 first:pt-10 text-font']) }}>
    <div class="container mx-auto max-w-3xl">
        <h2 class="text-3xl mb-8">{{ $heading }}</h2>

        <div class="[&>p]:mb-6 text-lg">
            {{ $slot }}
        </div>
    </div>
</div>
