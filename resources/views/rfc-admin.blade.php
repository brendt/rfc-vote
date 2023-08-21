@component('layouts.base')
    <div class="grid gap-4 px-4">
        <div class="p-4 flex justify-end bg-white">
            <a
                href="{{ action([App\Http\Controllers\RfcCreateController::class, 'create']) }}"
               class="bg-green-100 border border-green-500 text-green-500 hover:bg-green-500 hover:text-white p-2 py-1 font-bold rounded text-center"
            >New</a>
        </div>

        <div class="grid gap-2 divide-y divide-gray-300">
            @foreach($rfcs as $rfc)
                <div class="grid grid-cols-6 lg:grid-cols-12 p-4 gap-4 items-center">
                    <div class="col-span-6 lg:col-span-2 space-y-1">
                        <h2 class="font-bold">
                            {{ $rfc->title }}
                        </h2>

                        <div class="flex text-gray-500 text-sm">
                            {{ $rfc->published_at?->format('Y-m-d') }}
                            <span>&nbsp;—&nbsp;</span> {{ $rfc->ends_at?->format('Y-m-d') ?? 'unknown' }}
                        </div>

                        <div>
                            <div @class([
                                'inline-flex gap-2 items-baseline border-t border rounded-full px-2',
                                $rfc->isActive() ? 'border-agree-light bg-green-50' : 'border-disagree-light bg-red-50',
                            ])>
                                <div class="w-3 h-3 rounded-full {{ $rfc->isActive() ? 'bg-agree-light' : 'bg-disagree-light' }}"></div>
                                <span class="text-sm">{{ $rfc->isActive() ? 'Active' : 'Not active' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-6">
                        {{ $rfc->description }}
                    </div>

                    <div class="col-span-6 md:col-span-4 flex gap-3 items-center text-sm">
                        @if($rfc->arguments->isNotEmpty())
                            <div class="flex font-bold text-sm w-full text-white rounded-md">
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
                            <form action="{{ action(App\Http\Controllers\PublishRfcController::class, $rfc) }}" method="post">
                                @csrf()
                                <x-buttons.main-small-solid type="submit">
                                    Publish
                                </x-buttons.main-small-solid>
                            </form>
                        @endif

                        @if($rfc->ends_at === null)
                            <form action="{{ action(App\Http\Controllers\EndRfcController::class, $rfc) }}" method="post">
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
