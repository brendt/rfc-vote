@component('layouts.admin')
    <div class="grid gap-4 px-4">
        <div class="p-4 flex justify-end bg-white">
            <a href="{{ action([\App\Http\Controllers\RfcCreateController::class, 'create']) }}"
               class="bg-green-100 border border-green-500 text-green-500 hover:bg-green-500 hover:text-white p-2 py-1 font-bold rounded text-center"
            >New</a>
        </div>

        <div class="grid gap-2">
            @foreach($rfcs as $rfc)
                <div
                    class="grid grid-cols-12 p-4 gap-4 items-center {{ $rfc->isActive() ? 'bg-white border-l-8 border-blue-800' : 'bg-gray-50' }}">
                    <div class="grid col-span-2">
                        <span class="font-bold">
                            {{ $rfc->title }}
                        </span>
                        <div class="flex">
                            {{ $rfc->published_at?->format('Y-m-d') }}
                            <span>&nbsp;—&nbsp;</span> {{ $rfc->ends_at?->format('Y-m-d') }}
                        </div>
                    </div>

                    <div class="col-span-4">
                        {{ $rfc->description }}
                    </div>

                    <div class="col-span-6 flex justify-end gap-1 items-baseline text-sm">
                        @if($rfc->arguments->isNotEmpty())
                            <div
                                class="border-gray-700 border flex font-bold text-sm min-w-[20%]">
                                <div
                                    class="
                                    p-1 px-4 flex-grow text-left border-r border-gray-700
                                    min-w-[30%]
                                    bg-green-300 text-green-900
                                "
                                    style="width: {{ $rfc->percentage_yes }}%;"
                                >
                                    {{ $rfc->percentage_yes }}%
                                </div>
                                <div
                                    class="
                            p-1 px-4 flex-grow text-right border-gray-700
                            min-w-[30%]
                            bg-red-300 text-red-900
                        "
                                    style="width: {{ $rfc->percentage_no }}%;"
                                >
                                    {{ $rfc->percentage_no }}%
                                </div>
                            </div>
                        @endif

                        <a
                            href="{{ action([\App\Http\Controllers\RfcEditController::class, 'edit'], $rfc) }}"
                            class="bg-blue-100 border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white p-1 px-3 py-1 font-bold rounded text-center"
                        >Edit</a>

                        @if($rfc->published_at === null)
                            <form action="{{ action(\App\Http\Controllers\PublishRfcController::class, $rfc) }}" method="post">
                                @csrf()
                                <button
                                    type="submit"
                                    class="bg-blue-100 border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white p-1 px-3 py-1 font-bold rounded text-center"
                                >Publish</button>
                            </form>
                        @endif

                        @if($rfc->ends_at === null)
                            <form action="{{ action(\App\Http\Controllers\EndRfcController::class, $rfc) }}" method="post">
                                @csrf()
                                <button
                                    type="submit"
                                    class="bg-gray-100 border border-gray-500 text-gray-500 hover:bg-gray-500 hover:text-white p-1 px-3 py-1 font-bold rounded text-center"
                                >End</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endcomponent
