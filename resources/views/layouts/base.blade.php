<!doctype html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'RFC Vote' }} {{ app()->isProduction() ? '' : ' (local)' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    @include('feed::links')
    @stack('styles')
    @stack('scripts')

    {{ app(\App\Support\Meta::class)->render() }}

    @stack('meta')
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

@php
    $user = auth()->user();
@endphp

<nav class="bg-main bg-gradient-to-r from-main to-main-light z-10 p-4">
    <div class="container flex justify-between text-white gap-4 items-center m-auto">
        <div class="text-lg md:text-xl font-bold">
            <a href="/">RFC Vote<span class="hidden md:inline"> {{ app()->isProduction() ? '' : ' (local)' }}</span></a>
        </div>

        <div class="flex justify-end items-baseline gap-4 md:gap-6 font-bold text-sm md:text-md">
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
                    <span class="front-bold">{{ $user->username }}</span>

                    @if($user->getAvatarUrl())
                        <img
                            src="{{ $user->getAvatarUrl() }}"
                            class="rounded-full w-8 h-8 transition-transform group-hover:scale-110"
                            alt="{{ $user->name }} user avatar"
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
        <div
            class="container mx-auto px-4 mt-4 md:mt-12 max-w-[1200px] mb-8"
        >
            <div class="p-4 md:px-8 bg-blue-200 mb-4 md:mb-8 rounded-md md:rounded-full text-blue-900 font-bold">
                {{ flash()->message }}
            </div>
        </div>
    @endif

    {{ $slot }}
</div>

@if(isset($showToTopArrow) && $showToTopArrow === true)
    <div class="sticky flex w-full justify-end bottom-0 right-0 pb-3 pr-5"
         x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY; updateVisibility() })"
         x-data="{ isVisible: false, scrolled: 0, updateVisibility() { this.isVisible = (this.scrolled / (document.documentElement.scrollHeight - window.innerHeight)) >= 0.5; } }"
         x-show="isVisible"
    >
        <div x-show="isVisible"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"

             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform"
             x-transition:leave-end="opacity-0 transform"
        >
            <button onclick="window.scrollTo({top: 0});"
                    class="rounded-full bg-purple-600 p-4 text-white shadow-md hover:bg-purple-700 duration-700 hover:-translate-y-3 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg active:bg-purple-800 active:shadow-lg"
            >
                <x-icons.arrow-double-up/>
            </button>
        </div>
    </div>
@endif

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

    <div class="md:text-center">
        <p>
            Special thanks to <a class="text-purple-200 underline hover:no-underline" href="https://github.com/brendt/rfc-vote/graphs/contributors">numerous contributors</a> for sending PRs, and <a href="https://tighten.com/" class="text-purple-200 underline hover:no-underline">Tighten</a> for helping out with the design!
        </p>
    </div>

    <div class="flex justify-center gap-2 text-sm">
        <a href="/feed" class="underline hover:no-underline text-purple-200">RSS</a>
        <a href="https://github.com/brendt/rfc-vote" class="underline hover:no-underline text-purple-200">GitHub</a>
    </div>
</div>

@livewireScripts
</body>
</html>
