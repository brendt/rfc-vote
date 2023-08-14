<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFC Vote {{ app()->isProduction() ? '' : ' (local)' }}</title>
    @vite('resources/css/app.css')
    @livewireStyles

    <meta name="viewport" content="initial-scale=1, viewport-fit=cover" />
    <meta charset="UTF-8">
    {!!  $meta ?? null  !!}
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

@php
    $user = auth()->user();
@endphp

<nav class="bg-purple-800 bg-gradient-to-l from-purple-700 to-purple-900 z-10 px-4 py-5">
    <div class="container flex justify-between text-white gap-4 items-center m-auto">
        <div class="text-xl font-bold">
            <a href="/">RFC Vote {{ app()->isProduction() ? '' : ' (local)' }}</a>
        </div>

        <div class="flex justify-end items-baseline gap-4 md:gap-6 font-bold">
            <x-navbar.link
                href="{{ action(App\Http\Controllers\AboutController::class) }}"
                :isActive="request()->is('about')"
            >
                About
            </x-navbar.link>

            @if($user)
                @if($user->is_admin)
                    <x-navbar.link
                        href="{{ action(App\Http\Controllers\RfcAdminController::class) }}"
                        :isActive="request()->is('admin/*')"
                    >
                        Admin
                    </x-navbar.link>
                @endif

                <a
                    class="flex gap-3 items-center bg-purple-900 hover:bg-gray-800 group transition-colors pl-5 rounded-full"
                    href="{{ action([App\Http\Controllers\ProfileController::class, 'edit']) }}"
                >
                    <span class="front-bold">{{ $user->name }}</span>

                    @if($user->getAvatarUrl())
                        <img
                            src="{{ $user->getAvatarUrl() }}"
                            class="rounded-full w-8 h-8 transition-transform group-hover:scale-110"
                        />
                    @endif
                </a>
            @else
                <div>
                    <x-navbar.link
                        href="{{ action(App\Http\Controllers\LoginController::class) }}"
                        :isActive="request()->is('login')"
                    >
                        Login
                    </x-navbar.link>
                </div>
            @endif
        </div>
    </div>
</nav>

<div class="flex-1">
    @if(flash()->message)
        <div class="mt-4 z-50 bg-blue-400 max-w-[766px] mx-auto p-4 border border-blue-800 text-white font-bold">
            {{ flash()->message }}
        </div>
    @endif

    {{ $slot }}
</div>

<div class="
    p-8 text-white mt-8
    flex justify-center md:gap-6 gap-4 flex-col
    bg-purple-800
    bg-gradient-to-br from-purple-700 to-purple-900
">
    <div class="flex font-bold flex-wrap md:flex-nowrap gap-4 flex-1 justify-center">
        <span class="w-full md:w-auto">This project is open source, you can help out.</span>
        <div class="w-full md:w-auto">
            <a href="https://github.com/brendt/rfc-vote" class="bg-white px-4 p-2 text-purple-600 font-bold rounded hover:bg-purple-300 hover:text-purple-800">Check out the repository</a>
        </div>
    </div>

    <div class="text-center">
        <p>
            Special thanks to <a class="text-purple-200 underline hover:no-underline" href="https://github.com/brendt/rfc-vote/graphs/contributors">numerous contributors</a> for sending PRs, and <a href="https://tighten.com/" class="text-purple-200 underline hover:no-underline">Tighten</a> for helping out with the design!
        </p>
    </div>
</div>

@livewireScripts
</body>
</html>
