<html lang="en">
<head>
    <title>RFC</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-900">
<div class="flex items-center justify-center h-screen">
    <div class="w-[1200px] h-[627px]

    bg-purple-500
    bg-gradient-to-br from-purple-600 to-purple-900

    p-4 flex flex-col gap-8 items-center justify-center flex-wrap">
        <div class="text-center text-3xl prose">
            <h1 class="mt-0 text-white p-6 py-4">RFC Vote</h1>
        </div>
        <div class="w-[75%]">
            <div class="border-purple-600 border-4 flex rounded-full overflow-hidden
                            text-white font-bold text-3xl
                            ">
                <div
                    class="
                            p-6 py-4 flex-grow text-left border-r-4 border-purple-600
                            min-w-[15%]
                            bg-green-500
                        "
                    style="width: {{ $rfc->percentage_yes }}%;"
                >
                    {{ $rfc->percentage_yes }}%

                </div>
                <div
                    class="
                            p-6 py-4 flex-grow text-right border-purple-600
                            min-w-[15%]
                            bg-red-500
                        "
                    style="width: {{ $rfc->percentage_no }}%;"
                >
                    {{ $rfc->percentage_no }}%
                </div>
            </div>
            <div class="flex font-bold justify-between px-8 text-4xl">
                <span>
                </span>
                <span>
            </span>
            </div>
        </div>
    </div>
</div>
</body>
</html>
