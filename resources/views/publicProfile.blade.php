@component('layouts.base')

    <div
        class="container mx-auto px-4  mt-4 md:mt-12 max-w-[1200px] mb-8"
    >
        <div class="flex gap-2">
            <div
                @class([
                    'flex items-center gap-2 relative text-xs font-bold rounded-full pr-3 cursor-default',
                    'bg-purple-200 text-black' => $user->reputation < 1000,
                    'bg-purple-400 text-purple-100' =>  $user->reputation >= 1000,
                    'bg-purple-600 text-white' => $user->reputation >= 5000,
                ])
            >
                <img
                    src="{{ $user->getAvatarUrl() }}"
                    class="rounded-full shadow-sm w-[40px] h-[40px]"
                    alt="{{ $user->username }}'s avatar"
                />

                <h1 class="text-2xl font-bold">{{ $user->username }}</h1>
            </div>

            <div class="flex gap-2 items-center">
                <span class="font-bold">
                    {{ $user->reputation }}
                </span>
                @if($user->website_url)
                    <a
                        href="{{ $user->website_url }}"
                        target="_blank" rel="noopener noreferrer"
                    >
                        <x-icons.globe class="w-6 h-6" />
                    </a>
                @endif

                @if($user->github_url)
                    <a
                        href="{{ $user->github_url }}"
                        target="_blank" rel="noopener noreferrer"
                    >
                        <x-icons.github class="w-6 h-6" />
                    </a>
                @endif

                @if($user->twitter_url)
                    <a
                        href="{{ $user->twitter_url }}" class="text-black"
                        target="_blank" rel="noopener noreferrer"
                    >
                        <x-icons.x class="w-6 h-6" />
                    </a>
                @endif
            </div>
        </div>

        <div class="grid gap-4 mt-4">
            <h2 class="text-xl font-bold">Arguments and votes</h2>
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
