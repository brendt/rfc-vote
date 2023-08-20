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
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                             fill="currentColor"
                             class="w-6 h-6">
                            <path fill-rule="evenodd"
                                  d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM8.547 4.505a8.25 8.25 0 1011.672 8.214l-.46-.46a2.252 2.252 0 01-.422-.586l-1.08-2.16a.414.414 0 00-.663-.107.827.827 0 01-.812.21l-1.273-.363a.89.89 0 00-.738 1.595l.587.39c.59.395.674 1.23.172 1.732l-.2.2c-.211.212-.33.498-.33.796v.41c0 .409-.11.809-.32 1.158l-1.315 2.191a2.11 2.11 0 01-1.81 1.025 1.055 1.055 0 01-1.055-1.055v-1.172c0-.92-.56-1.747-1.414-2.089l-.654-.261a2.25 2.25 0 01-1.384-2.46l.007-.042a2.25 2.25 0 01.29-.787l.09-.15a2.25 2.25 0 012.37-1.048l1.178.236a1.125 1.125 0 001.302-.795l.208-.73a1.125 1.125 0 00-.578-1.315l-.665-.332-.091.091a2.25 2.25 0 01-1.591.659h-.18c-.249 0-.487.1-.662.274a.931.931 0 01-1.458-1.137l1.279-2.132z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </a>
                @endif

                @if($user->github_url)
                    <a
                        href="{{ $user->github_url }}"
                        target="_blank" rel="noopener noreferrer"
                    >
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M10 .333A9.911 9.911 0 0 0 6.866 19.65c.5.092.678-.215.678-.477 0-.237-.01-1.017-.014-1.845-2.757.6-3.338-1.169-3.338-1.169a2.627 2.627 0 0 0-1.1-1.451c-.9-.615.07-.6.07-.6a2.084 2.084 0 0 1 1.518 1.021 2.11 2.11 0 0 0 2.884.823c.044-.503.268-.973.63-1.325-2.2-.25-4.516-1.1-4.516-4.9A3.832 3.832 0 0 1 4.7 7.068a3.56 3.56 0 0 1 .095-2.623s.832-.266 2.726 1.016a9.409 9.409 0 0 1 4.962 0c1.89-1.282 2.717-1.016 2.717-1.016.366.83.402 1.768.1 2.623a3.827 3.827 0 0 1 1.02 2.659c0 3.807-2.319 4.644-4.525 4.889a2.366 2.366 0 0 1 .673 1.834c0 1.326-.012 2.394-.012 2.72 0 .263.18.572.681.475A9.911 9.911 0 0 0 10 .333Z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </a>
                @endif

                @if($user->twitter_url)
                    <a
                        href="{{ $user->twitter_url }}" class="text-black"
                        target="_blank" rel="noopener noreferrer"
                    >𝕏</a>
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
