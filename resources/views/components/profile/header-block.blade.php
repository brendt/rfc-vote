@php
    /**
     * @var Illuminate\View\ComponentSlot $slot
     * @var int $value
     * @var string $label
     */
@endphp

<div class="bg-white p-4 max-w-[180px] rounded-lg shadow-md">
    <div class="max-w-[80px] mx-auto text-slate-500">
        {{ $slot }}
    </div>

    <div class="text-center space-y-3 mt-1.5">
        <h3 class="text-3xl font-bold text-slate-600">{{ $value }}</h3>
        <h2 class="text-xl leading-5 text-slate-500">{{ $label }}</h2>
    </div>
</div>
