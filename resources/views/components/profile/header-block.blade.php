@php
    /**
     * @var Illuminate\View\ComponentSlot $slot
     * @var int $value
     * @var string $label
     */
@endphp

<div class="bg-white dark:bg-main p-4 w-[180px] rounded-lg shadow-md ml-auto flex-shrink-0">
    <div class="max-w-[60px] sm:max-w-[80px] mx-auto text-slate-500">
        {{ $slot }}
    </div>

    <div class="text-center  space-y-3 mt-1 sm:mt-1.5">
        <h3 class="text-2xl sm:text-3xl font-bold text-slate-600 dark:text-font">{{ $value }}</h3>
        <h2 class="text-xl leading-5 text-slate-500 dark:text-font">{{ $label }}</h2>
    </div>
</div>
