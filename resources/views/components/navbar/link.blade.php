@php
    /**
     * @var boolean $isActive
     * @var Illuminate\View\ComponentAttributeBag $attributes
     */
@endphp

<a
    {{ $attributes->merge([
        'class' => 'relative group dark:text-gray-200 w-full md:w-auto p-4 md:p-1 md:border-none ' . ($isActive ? 'bg-slate-100 md:bg-transparent rounded-xl' : 'border-b last:border-none')
    ]) }}
>
    {{ $slot }}

    <div
        @class([
            'hidden md:block absolute bottom-0 top-7 -left-0.5 -right-0.5 transition-transform duration-300',
            'group-hover:opacity-100 group-hover:translate-y-0 h-1 bg-purple-200 dark:bg-gray-500 rounded-full',
            $isActive ? 'opacity-0 md:opacity-100' : 'opacity-0 -translate-y-1',
        ])
    ></div>
</a>
