@php
    /**
     * @var Illuminate\View\ComponentSlot $slot
     * @var array{id: int, name: string, url: string, contributions: string[]}[] $contributors
     */
@endphp

<x-about.section heading="Our contributors">
    <ul class="flex flex-wrap justify-center gap-3">
        @foreach($contributors as $c)
            <li @class([
                'flex gap-4 rounded-[50px_13px_13px_50px] bg-background pl-1 pr-4 py-1 group',
                'transition-all duration-300',
            ])>
                <img
                    src="{{ "https://avatars.githubusercontent.com/u/{$c->id}" }}"
                    alt="{{ $c->name }}"
                    width="460"
                    height="460"
                    class="w-16 h-auto shadow-md rounded-full"
                />

                <div class="flex justify-center">
                    <div class="flex-col justify-center text-[.9rem] leading-5 hidden group-hover:flex transition-all duration-300">
                        <span><b>Name:</b> {{ $c->name }}</span>
                        <span><b>Focus:</b> {{ implode(', ', $c->contributions) }}</span>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</x-about.section>
