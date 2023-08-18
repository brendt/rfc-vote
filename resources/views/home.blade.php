@component('layouts.base')
    <div class="container mx-auto px-4 mt-4 md:mt-12 max-w-[1200px]">
        <x-email-optin-banner :user="auth()->user()"/>
    </div>

    <div class="container max-w-[1200px] mx-auto px-4 grid lg:grid-cols-3 gap-5 mt-4 md:mt-8">
        @foreach ($rfcs as $rfc)
            <x-card-link :href="action(App\Http\Controllers\RfcDetailController::class, $rfc)">
                <div class="text-xl text-gray-800 font-bold px-2 border-b pb-4 mb-2">
                    {{ $rfc->title }}
                </div>

                <x-markdown class="px-2 text-gray-800">{!! $rfc->teaser !!}</x-markdown>

                <div class="mt-3">
                    <div class="bg-gray-200 p-1 rounded-full">
                        <div class="flex font-bold rounded-full overflow-hidden">
                            <div
                                @class([
                                    'p-1 flex-grow bg-gradient-to-r',
                                    'from-teal-700 to-teal-500' => $rfc->majorityYes(),
                                    'from-pink-500 to-pink-600' => ! $rfc->majorityYes(),
                                ])
                                style="width: {{ $rfc->percentage_yes }}%;"
                            ></div>
                            <div
                                @class([
                                    'p-1 flex-grow bg-gradient-to-r',
                                    'from-pink-700 to-pink-500' => $rfc->majorityNo(),
                                    'from-pink-600 to-pink-500' => ! $rfc->majorityNo(),
                                ])
                                style="width: {{ $rfc->percentage_no }}%;"
                            ></div>
                        </div>
                    </div>

                    <div class="flex justify-between p-1 px-2 text-sm">
                        <span
                            @class([
                                'text-teal-700 font-bold' => $rfc->majorityYes(),
                                'text-gray-700' => ! $rfc->majorityYes(),
                            ])
                        >{{ $rfc->percentage_yes }}%</span>
                        <span
                            @class([
                                'text-red-700 font-bold' => $rfc->majorityNo(),
                                'text-gray-700' => ! $rfc->majorityNo(),
                            ])
                        >{{ $rfc->percentage_no }}%</span>
                    </div>
                </div>

                <div class="flex justify-start text-xs mt-3 gap-2 uppercase">
                    <x-tag class="font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-gray-700">
                            <path fill-rule="evenodd" d="M4.804 21.644A6.707 6.707 0 006 21.75a6.721 6.721 0 003.583-1.029c.774.182 1.584.279 2.417.279 5.322 0 9.75-3.97 9.75-9 0-5.03-4.428-9-9.75-9s-9.75 3.97-9.75 9c0 2.409 1.025 4.587 2.674 6.192.232.226.277.428.254.543a3.73 3.73 0 01-.814 1.686.75.75 0 00.44 1.223zM8.25 10.875a1.125 1.125 0 100 2.25 1.125 1.125 0 000-2.25zM10.875 12a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0zm4.875-1.125a1.125 1.125 0 100 2.25 1.125 1.125 0 000-2.25z" clip-rule="evenodd" />
                        </svg>

                        {{ $rfc->arguments->count() }}
                    </x-tag>

                    <livewire:rfc-counter :rfc="$rfc" :vote-type="\App\Models\VoteType::YES"/>
                    <livewire:rfc-counter :rfc="$rfc" :vote-type="\App\Models\VoteType::NO"/>
                </div>
            </x-card-link>
        @endforeach
    </div>

@endcomponent
