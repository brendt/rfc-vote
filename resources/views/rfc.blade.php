@component('layouts.base')
    <div class="container mx-auto px-4 grid lg:grid-cols-3 gap-6 md:gap-12 mt-4 md:mt-12">
        <h1 class="font-mono text-3xl font-bold col-span-3 text-center">
            [VOTE] {{ $rfc->title }}
        </h1>

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
