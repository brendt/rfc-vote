@php
    /**
     * @var boolean $isActive
     * @var int|null $notificationNumber
     * @var Illuminate\View\ComponentAttributeBag $attributes
     */
@endphp

<a
    {{ $attributes->merge([
        'class' => 'text-sm md:text-md relative text-white px-4 w-64 py-3 flex gap-4 ' . ($isActive ? 'bg-purple-700' : 'hover:bg-black')
    ]) }}
>
    {{ $slot }}

    @isset($notificationNumber)
        <span class="absolute top-1.5 left-8 bg-red-500 text-white text-xs rounded-full min-w-[17px] h-[17px] inline-flex items-center justify-center p-0.5">
            {{ $notificationNumber }}
        </span>
    @endisset
</a>
