@component('layouts.base')
    <div class="mx-auto px-4 gap-6 md:gap-12 mt-4 md:mt-12 mb-8">
        <div class="grid gap-2">
            @foreach($rfcs as $rfc)
                <div class="grid grid-cols-12 p-4 gap-4 items-center {{ $rfc->isActive() ? 'bg-white border-l-8 border-blue-800' : 'bg-gray-50' }}">
                    <div class="grid col-span-2">
                        <span class="font-bold">
                            {{ $rfc->title }}
                        </span>
                        <div class="flex">
                            {{ $rfc->published_at?->format('Y-m-d') }} <span>&nbsp;—&nbsp;</span> {{ $rfc->ends_at?->format('Y-m-d') }}
                        </div>
                    </div>

                    <div class="col-span-4">
                        {{ $rfc->description }}
                    </div>

                    <div class="col-span-6 flex justify-end gap-4 items-center">
                        @if($rfc->votes->isNotEmpty())
                            <div class="border-gray-700 border flex font-bold text-sm min-w-[30%]">
                            <div
                                class="
                                    p-1 px-4 flex-grow text-left border-r border-gray-700
                                    min-w-[15%]
                                    bg-green-300 text-green-900
                                "
                                style="width: {{ $rfc->percentage_yes }}%;"
                            >
                                {{ $rfc->percentage_yes }}%
                            </div>
                            <div
                                class="
                            p-1 px-4 flex-grow text-right border-gray-700
                            min-w-[15%]
                            bg-red-300 text-red-900
                        "
                                style="width: {{ $rfc->percentage_no }}%;"
                            >
                                {{ $rfc->percentage_no }}%
                            </div>
                        </div>

                            <span>
                            {{ $rfc->votes->count() }} votes, {{ $rfc->arguments->count() }} arguments
                            </span>
                        @endif

                        <a
                            href="{{ $rfc->url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="bg-[#7a86b8] border border-[#4f5b93] hover:bg-[#4f5b93] text-white p-2 py-1 font-bold rounded min-w-[80px] text-center"
                        >Read RFC</a>

                        <a
                            href="{{ action([\App\Http\Controllers\RfcEditController::class, 'edit'], $rfc) }}"
                            class="bg-blue-100 border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white p-2 py-1 font-bold rounded min-w-[80px] text-center"
                        >Edit</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endcomponent
