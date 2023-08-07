<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFC Vote</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="bg-gray-100">

@php
    $user = auth()->user();
@endphp

<div class="bg-purple-800 flex justify-end text-white p-4 gap-4 items-center fixed top-0 left-0 w-full">
        <a href="/">Home</a>
    @if($user)
{{--        <div>--}}
{{--            <a href="{{ route('logout') }}">Logout</a>--}}
{{--        </div>--}}
        @if($user->is_admin)
            <a href="{{ action(\App\Http\Controllers\RfcAdminController::class) }}">Admin</a>
        @endif
        <a href="{{ action(\App\Http\Controllers\LogoutController::class) }}">Logout</a>
        <a class="flex gap-2 items-center" href="{{ action([\App\Http\Controllers\ProfileController::class, 'edit']) }}">
            <span class="front-bold">{{ $user->name }}</span>
            <livewire:user-reputation-counter :user="$user"/>
        </a>
    @else
        <div>
            <a href="{{ action(\App\Http\Controllers\LoginController::class) }}">Login</a>
        </div>
    @endif
</div>

<div class="mt-[150px]">
    {{ $slot }}
</div>

<div class="flex justify-center p-8 bg-purple-900 text-white mt-8">
    <div class="flex font-bold flex-wrap md:flex-nowrap gap-4 flex-1 justify-center">
        <span class="w-full md:w-auto">This project is open source, you can help out.</span>
        <div class="w-full md:w-auto">
            <a href="https://github.com/brendt/rfc-vote" class="bg-white px-4 p-2 text-purple-600 font-bold rounded hover:bg-purple-300 hover:text-purple-800">Check out the repository</a>
        </div>
    </div>
</div>

@livewireScripts
</body>
</html>
