@component('layouts.base')
    <div class="container mx-auto px-4 grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-12 mt-4 md:mt-12 max-w-[1200px] mb-8">
        <div class="col-span-3">
            <h1 class="font-mono text-3xl font-bold col-span-3 flex justify-center gap-2 md:gap-4 items-center">
                <span>{{ $rfc->title }}</span>
                <a
                    href="{{ $rfc->url }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="text-xs bg-[#7a86b8] border border-[#4f5b93] hover:bg-[#4f5b93] text-white p-2 py-1 font-bold rounded min-w-[80px] text-center"
                >Read RFC</a>
            </h1>

            <p class="mt-2 md:mt-4 md:max-w-[50%] md:text-center md:mx-auto">
                {{ $rfc->description }}
            </p>
        </div>

        <div class="col-span-3">
            <livewire:vote-bar :rfc="$rfc->withoutRelations()" :user="$user?->withoutRelations()"/>
        </div>

        @if($user)
            <div class="col-span-3">
                <livewire:argument-form :rfc="$rfc->withoutRelations()" :user="$user->withoutRelations()"/>
            </div>
        @endif

        <div class="col-span-3">
            <livewire:argument-list :rfc="$rfc" :user="$user"/>
        </div>
    </div>
@endcomponent
