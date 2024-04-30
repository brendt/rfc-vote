@component('layouts.base')
    <div class="container max-w-[1200px] mx-auto px-4 grid gap-4 my-10">
        <x-email-optin-banner :user="auth()->user()"/>

        <x-home.title>Open RFCs</x-home.title>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($rfcs as $rfc)
                <x-card-link
                    :to="action(App\Http\Controllers\RfcDetailController::class, $rfc)"
                    :user-vote="$user ? $rfc->userArgument($user)?->vote_type : null"
                >
                    <div class="text-xl font-bold px-2 border-divider border-b pb-4 mb-2 text-font">
                        {{ $rfc->title }}
                    </div>

                    <div class="flex-1 px-2 text-font">{!! md($rfc->teaser) !!}</div>

                    <div class="mt-3">
                        <div class="bg-vote-bar-background p-1 rounded-full">
                            <div class="flex font-bold rounded-full overflow-hidden">
                                <div
                                    class="p-1 flex-grow bg-gradient-to-r from-agree to-agree-light"
                                    style="width: {{ $rfc->percentage_yes }}%;"
                                ></div>
                                <div
                                    class="p-1 flex-grow bg-gradient-to-r from-disagree to-disagree-light"
                                    style="width: {{ $rfc->percentage_no }}%;"
                                ></div>
                            </div>
                        </div>

                        <div class="flex justify-between p-1 px-2 text-sm">
                            <span class="text-agree font-bold">
                                {{ $rfc->percentage_yes }}%
                            </span>
                            <span class="text-disagree font-bold">
                                {{ $rfc->percentage_no }}%
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-wrap justify-start text-xs mt-3 gap-2 uppercase items-center">
                        <x-tag class="font-bold">
                            <x-icons.chat-bubble class="w-4 h-4" />
                            {{ $rfc->arguments->count() }}
                        </x-tag>

                        <livewire:rfc-counter :rfc="$rfc" :vote-type="App\Models\VoteType::YES" />
                        <livewire:rfc-counter :rfc="$rfc" :vote-type="App\Models\VoteType::NO" />
                    </div>
                </x-card-link>
            @endforeach
        </div>

        @if($argumentOfTheDay)
            <x-home.title>Argument of the Day</x-home.title>

            <x-argument-card.card
                :user="$argumentOfTheDay->user"
                :rfc="$argumentOfTheDay->rfc"
                :argument="$argumentOfTheDay"
                :readonly="true"
            />
        @endif
    </div>

@endcomponent
