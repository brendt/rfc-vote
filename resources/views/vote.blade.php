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

<div class="container mx-auto px-4 grid gap-6 md:gap-12 mt-4 md:mt-8">
    <div class="p-4">
        <h1 class="font-mono font-bold text-3xl text-center text-gray-700">{{ $vote->title }}</h1>
    </div>

    <livewire:vote-bar :vote="$vote"/>

    <div class="flex justify-center gap-4">
        <a href="{{ $vote->rfc_link }}" target="_blank" rel="noopener noreferrer" class="justify-center
            font-mono
            bg-blue-100
            border-4
            border-blue-400
            p-4
            px-8
            text-lg
            text-blue-500
            hover:bg-blue-400
            hover:text-white">Read the RFC</a>

        <livewire:vote-button :vote="$vote" :user="$user"/>
    </div>

    <livewire:vote-argument-counter :vote="$vote"/>

    <livewire:vote-argument-list :vote="$vote" :user="$user"/>
</div>

@livewireScripts
</body>
</html>
