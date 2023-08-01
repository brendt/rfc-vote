<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFC Vote</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body>

@php
    $user = auth()->user();
@endphp

<div class="bg-gray-800 flex justify-end text-white p-4 gap-4">
    @if($user)
        <div>
            <span class="front-bold">{{ $user->name }}</span>
            <livewire:user-reputation-counter :user="$user"/>
        </div>
        <div>
            <a href="{{ route('logout') }}">Logout</a>
        </div>
    @else
        <div>
            <a href="{{ route('login') }}">Login</a>
        </div>
    @endif
</div>

{{ $slot }}
@livewireScripts
</body>
</html>
