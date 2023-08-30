@php
    /**
     * @var Illuminate\View\ComponentSlot $slot
     * @var array{id: int, name: string, url: string, contributions: string[]}[] $contributors
     */
@endphp

<x-about.section heading="Our contributors">
    <ul>
        @foreach($contributors as $contributor)
            <li>
                <x-about.link href="{{ $contributor->url }}">{{ $contributor->name }}</x-about.link>:
                <x-about.link href="{{ $contributor->contributionsUrl }}">
                    {{ implode(', ', $contributor->contributions) }}
                </x-about.link>
            </li>
        @endforeach
    </ul>
</x-about.section>
