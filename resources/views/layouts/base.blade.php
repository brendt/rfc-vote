<!doctype html>
<html
    x-data="darkTheme"
    x-cloak
    :data-theme="darkMode ? 'dark' : 'light'"
    :class="{ 'dark': darkMode }"
    class="scroll-smooth"
    lang="en"
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

    {{ app(App\Support\Meta::class)->render() }}

    @stack('meta')
</head>

<body class="min-h-screen flex flex-col bg-background transition-colors duration-300">

@php
    $user = auth()->user();
@endphp

<x-navbar.navbar :user="$user" />

<div class="flex-1">
    @if (flash()->message)
        <div class="container mx-auto mt-6">
            <x-success-message>{{ flash()->message }}</x-success-message>
        </div>
    @endif

    {{ $slot }}
</div>

@if(isset($showToTopArrow) && $showToTopArrow === true)
    <x-buttons.to-top />
@endif

<x-footer.footer />

@livewireScripts
</body>
</html>
