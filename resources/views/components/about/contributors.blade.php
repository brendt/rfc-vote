@php
    /**
     * @var Illuminate\View\ComponentSlot $slot
     * @var array{id: int, name: string, url: string, contributions: string[]}[] $contributors
     */
@endphp

<x-about.section heading="Our contributors">
    <div class="flex flex-wrap justify-center gap-4">
        @foreach($contributors as $c)
            <a href="{{ $c->url }}" target="_blank" @class([
                'flex gap-4 items-center transition-all duration-300 bg-background',
                'rounded-[50px_13px_13px_50px] pr-4 hover:bg-admin-navbar-background',
            ])>
                <img
                    src="{{ "https://avatars.githubusercontent.com/u/{$c->id}" }}"
                    alt="{{ $c->name }}"
                    width="460"
                    height="460"
                    class="w-16 h-16 shadow-md rounded-full"
                />

                <div class="flex justify-center">
                    <div class="flex-col justify-center text-[.9rem] leading-5 flex">
                        <span><b>Name:</b> {{ $c->name }}</span>
                        <span><b>Focus:</b> {{ implode(', ', $c->contributions) }}</span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</x-about.section>
