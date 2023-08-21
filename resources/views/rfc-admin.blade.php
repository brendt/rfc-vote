@component('layouts.base')
    <div class="grid gap-4 px-4">
        <div class="p-4 flex justify-end bg-white">
            <a
                href="{{ action([\App\Http\Controllers\RfcCreateController::class, 'create']) }}"
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

                    <div class="col-span-6 flex justify-end gap-2 items-center text-sm">
                        @if($rfc->arguments->isNotEmpty())
                            <div class="flex font-bold text-sm min-w-[20%] text-white rounded-md">
                                <div
                                    class="rounded-l-md pl-2 py-[6px] items-center text-left border-r border-gray-700 min-w-[30%] bg-agree text-xs"
                                    style="width: {{ $rfc->percentage_yes }}%;"
                                >
                                    {{ $rfc->percentage_yes }}<small>%</small>
                                </div>

                                <div class="bg-white w-[1px]"></div>

                                <div
                                    class="rounded-r-md pr-2 py-[6px] items-center text-right border-gray-700 min-w-[30%] bg-disagree text-xs"
                                    style="width: {{ $rfc->percentage_no }}%;"
                                >
                                    {{ $rfc->percentage_no }}<small>%</small>
                                </div>
                            </div>
                        @endif

                        <x-buttons.main-small-solid href="{{ action([App\Http\Controllers\RfcEditController::class, 'edit'], $rfc) }}">
                            <x-icons.pen class="w-4 h-4" />
                            Edit
                        </x-buttons.main-small-solid>

                        @if($rfc->published_at === null)
                            <form action="{{ action(\App\Http\Controllers\PublishRfcController::class, $rfc) }}" method="post">
                                @csrf()
                                <x-buttons.main-small-solid type="submit">
                                    Publish
                                </x-buttons.main-small-solid>
                            </form>
                        @endif

                        @if($rfc->ends_at === null)
                            <form action="{{ action(\App\Http\Controllers\EndRfcController::class, $rfc) }}" method="post">
                                @csrf()
                                <x-buttons.main-small-solid type="submit" class="!border-disagree !text-disagree">
                                    End
                                </x-buttons.main-small-solid>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endcomponent
