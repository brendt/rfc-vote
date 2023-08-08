<html lang="en">
<head>
    <title>RFC</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-900">
<div class="flex items-center justify-center h-screen">
    <div class="w-[949px] h-[495px] bg-white p-4 flex flex-col gap-4 items-center justify-center flex-wrap">
        <div class="text-center text-3xl font-mono">
            <h1>{{ $rfc->title }}</h1>
        </div>
        <div class="border-gray-700 border-2 flex font-bold w-full">
            <div
                class="
                            p-2 px-4 flex-grow text-left border-r-2 border-gray-700
                            min-w-[15%]
                            bg-green-300 text-green-900
                        "
                style="width: {{ $rfc->percentage_yes }}%;"
            >
                {{ $rfc->percentage_yes }}%
            </div>
            <div
                class="
                            p-2 px-4 flex-grow text-right border-gray-700
                            min-w-[15%]
                            bg-red-300 text-red-900
                        "
                style="width: {{ $rfc->percentage_no }}%;"
            >
                {{ $rfc->percentage_no }}%
            </div>
        </div>
    </div>
</div>
</body>
</html>
