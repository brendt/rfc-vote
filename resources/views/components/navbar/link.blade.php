@php
    /**
     * @var boolean $isActive
     * @var Illuminate\View\ComponentAttributeBag $attributes
     */
@endphp

<a
    {{ $attributes->merge([
        'class' => 'relative group text-gray-700 md:text-inherit dark:text-gray-300 text-[1rem] border-divider w-full md:w-auto p-4 md:p-1 md:border-none border-b last:border-none md:!bg-transparent ' . ($isActive ? 'bg-background dark:bg-main md:bg-transparent' : '')
    ]) }}
>
    {{ $slot }}

    <div
        @class([
            'hidden md:block absolute bottom-0 top-7 -left-0.5 -right-0.5 transition-transform duration-300',
            'group-hover:opacity-100 group-hover:translate-y-0 h-1 bg-purple-200 dark:bg-gray-400 rounded-full',
            $isActive ? 'opacity-0 md:opacity-100' : 'opacity-0 -translate-y-1',
        ])
    ></div>
</a>
