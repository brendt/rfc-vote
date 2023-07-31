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

<div class="container mx-auto px-4 grid lg:grid-cols-3 gap-6 md:gap-12 mt-4 md:mt-8">
    @foreach($votes as $vote)
        <a class="border-4 border-gray-700 shadow-lg" href="{{ action(\App\Http\Controllers\VoteController::class, $vote) }}">
            <h1 class="font-mono p-4 ">
                {{ $vote->title }}
            </h1>

            <div>
                <div class="flex border-t-4 border-gray-700 font-bold font-mono">
                    <div class="bg-green-200 text-green-900 p-2 px-4 flex-grow text-left border-r-2 border-gray-700" style="width:{{ $vote->percentage_yes }}%; min-width: 10%;">
                        {{ $vote->percentage_yes }}%
                    </div>
                    <div class="bg-red-200 p-2 px-4 text-red-900 flex-grow text-right border-l-2 border-gray-700" style="width:{{ $vote->percentage_no }}%; min-width: 10%;">
                        {{ $vote->percentage_no }}%
                    </div>
                </div>
            </div>
        </a>
    @endforeach
</div>

@livewireScripts
</body>
</html>
