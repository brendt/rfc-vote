@php
    /**
     * @var App\Models\User $user
     */
@endphp

@component('layouts.base')

    <div class="container mx-auto px-4 mt-8 md:mt-12 max-w-[1200px] mb-8">
        <x-profile.header :user="$user" />

        <div class="grid gap-4 mt-6">
            <h2 class="text-3xl font-bold text-font">
                Arguments and votes
            </h2>

            @forelse ($user->argumentVotes->pluck('argument')->sortByDesc('created_at') as $argument)
                <div class="grid gap-2">
                    <x-argument-card.card
                        :user="$user"
                        :rfc="$argument->rfc"
                        :argument="$argument"
                        :readonly="true"
                    />
                </div>
            @empty
                <h2 class="text-xl text-font opacity-70">
                    {{ $user->name }} doesn't have any arguments yet
                </h2>
            @endforelse
        </div>
    </div>

@endcomponent
