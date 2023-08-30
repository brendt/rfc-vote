@php
    /**
     * @var Illuminate\View\ComponentSlot $slot
     * @var string $author
     * @var string|null $link
     */
@endphp

<blockquote class="mt-7 bg-info p-7 rounded-2xl">
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
