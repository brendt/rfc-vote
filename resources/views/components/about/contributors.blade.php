@php
    /**
     * @var Illuminate\View\ComponentSlot $slot
     * @var array{id: int, name: string, url: string, contributions: string[]}[] $contributors
     */
@endphp

<x-about.section heading="Our contributors">
    <ul class="grid grid-cols-10 gap-4">
        @foreach($contributors as $c)
            <li class="flex gap-2">
                <div>
                    <img
                        src="{{ "https://avatars.githubusercontent.com/u/{$c->id}" }}"
                        alt="{{ $c->name }}"
                        width="460"
                        height="460"
                        class="w-full shadow-md rounded-full"
                    />
                </div>
            </li>
        @endforeach
    </ul>
</x-about.section>
