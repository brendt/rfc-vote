@component('layouts.base')

    <div class="container mx-auto px-4 mt-8 md:mt-12 max-w-[1200px] mb-8">
        <x-profile.header :user="$user" />

        <div class="grid gap-4 mt-6">
            <h2 class="text-xl font-bold">
                {{ __('Arguments and votes') }}
            </h2>

            @foreach ($user->argumentVotes->pluck('argument')->sortByDesc('created_at') as $argument)
                <div class="grid gap-2">
{{--                    <a class="px-2 underline hover:no-underline text-lg font-bold" href="{{ action(\App\Http\Controllers\RfcDetailController::class, $argument->rfc) }}">--}}
{{--                        {{ $argument->rfc->title }}--}}
{{--                    </a>--}}
                    <x-argument-card.card
                        :user="$user"
                        :rfc="$argument->rfc"
                        :argument="$argument"
                        :readonly="true"
                    />
                </div>
            @endforeach
        </div>
    </div>

@endcomponent
