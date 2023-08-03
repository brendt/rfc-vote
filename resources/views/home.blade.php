@component('layouts.base')

    <div class="container mx-auto px-4 grid lg:grid-cols-3 gap-6 md:gap-12 mt-4 md:mt-8">
        @foreach ($rfcs as $rfc)
            <a
                href="{{ action(\App\Http\Controllers\RfcDetailController::class, $rfc) }}"
                class="
                border-gray-700 border
                bg-white
                rounded
                shadow-md
               flex flex-col
               justify-between
               overflow-hidden
               hover:shadow-2xl
               hover:outline

            "
            >
                <div class="px-4 mt-4 font-bold font-mono">
                    {{ $rfc->title }}
                </div>

                <p class="px-4 mb-2">{{ $rfc->description }}</p>

                <div class="border-gray-700 border-t flex font-bold">
                    <div
                        class="
                            p-2 px-4 flex-grow text-left border-r border-gray-700
                            min-w-[15%]
                            bg-green-300 text-green-900
                        "
                        style="width: {{ $rfc->percentage_yes }}%;"
                        wire:click="vote('{{ \App\Models\VoteType::YES }}')"
                    >
                        {{ $rfc->percentage_yes }}%
                    </div>
                    <div
                        class="
                            p-2 px-4 flex-grow text-right border-gray-700
                            min-w-[15%]
                            bg-red-300 text-red-900
                        "
                        style="width: {{ $rfc->percentage_yes }}%;"
                        wire:click="vote('{{ \App\Models\VoteType::YES }}')"
                    >
                        {{ $rfc->percentage_yes }}%
                    </div>
                </div>
            </a>
        @endforeach
    </div>

@endcomponent
