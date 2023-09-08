@php
    /**
     * @var Illuminate\View\ComponentSlot $slot
     * @var App\Models\Contributor[] $contributors
     */
@endphp

<x-about.section heading="Our contributors">
    <div {{dusk('about-contributors')}} class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 pt-2">
        @foreach($contributors as $c)
            <a href="{{ $c->url }}" target="_blank" @class([
                'flex gap-2 items-center transition-all duration-300 bg-background w-full',
                'rounded-[50px_13px_13px_50px] pr-2 hover:bg-admin-navbar-background',
            ])>
                <img
                    src="{{ "https://avatars.githubusercontent.com/u/{$c->id}" }}"
                    alt="{{ $c->name }}"
                    width="460"
                    height="460"
                    class="w-12 h-12 md:w-16 md:h-16 shadow-md rounded-full"
                />

                <div class="flex justify-center">
                    <div class="flex-col justify-center text-[.9rem] leading-5 flex my-0.5">
                        <b class="{{ mb_strlen($c->name) > 10 ? 'text-xs' : 'text-sm' }}">{{ $c->name }}</b>

                        <span class="opacity-60 text-xs md:text-md leading-4">
                            {{ implode(', ', $c->contributions) }}
                        </span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</x-about.section>
