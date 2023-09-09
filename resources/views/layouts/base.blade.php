<!doctype html>
<html :data-theme="darkMode ? 'dark' : 'light'" lang="en"
      class="scroll-smooth"
      x-cloak
      x-data="{
        darkMode: localStorage.getItem('theme') === null ? window.matchMedia('(prefers-color-scheme: dark)').matches : localStorage.getItem('theme') === 'dark',
        toggle() {
          this.darkMode = !this.darkMode;
          localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
        }
      }"
      :class="{ 'dark': darkMode }"
>
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
<body class="min-h-screen flex flex-col bg-background transition-colors duration-300" >

@php
    $user = auth()->user();
@endphp

<x-navbar.navbar :user="$user" />

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
    <div class="sticky flex self-end justify-end bottom-0 pb-3 right-6"
        x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY; updateVisibility() })"
        x-data="{ isVisible: false, scrolled: 0, updateVisibility() { this.isVisible = (this.scrolled / (document.documentElement.scrollHeight - window.innerHeight)) >= 0.5; } }"
        x-show="isVisible"
    >
        <button
            x-show="isVisible"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"

            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-2"
            @click="window.scrollTo({top: 0});"
            class="rounded-full bg-purple-600 p-4 text-white shadow-md hover:bg-purple-700 duration-700 hover:-translate-y-3 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg active:bg-purple-800 active:shadow-lg"
        >
            <x-icons.arrow-double-up/>
        </button>
    </div>
@endif

<x-footer.footer />

@livewireScripts
</body>
</html>
