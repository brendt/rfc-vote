@php
    /**
     * @var Illuminate\View\ComponentSlot $slot
     * @var string $author
     * @var string $image
     * @var string|null $link
     */
@endphp

<div class="flex flex-col-reverse md:flex-row gap-4 md:gap-6 items-center mt-8">
    <blockquote class="bg-info p-5 md:p-7 rounded-3xl relative">
        {{-- decoration for the dialog bubble (like little triangle on the right) --}}
        <div class="absolute right-1/2 md:-right-2 top-0 md:top-1/2 translate-x-1/2 md:translate-x-0 -translate-y-1/2 w-4 h-4 bg-info rotate-45"></div>

        <p class="text-font leading-6 italic">{{ $slot }}</p>

        <p class="font-bold text-font-second mt-3">
            —

            @isset ($link)
                <a href="{{ $link }}" class="hover:underline">
                    {{ $author }}
                    <x-icons.external-link class="inline-block w-4 h-3 -mt-3" />
                </a>
            @else
                {{ $author }}
            @endisset
        </p>
    </blockquote>

    <img
        src="{{ $image }}"
        alt="{{ $author }}"
        class="w-20 h-20 rounded-full shadow-md"
    />
</div>
