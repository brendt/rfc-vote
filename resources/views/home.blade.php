@component('layouts.base')
    <div class="container mx-auto px-4 mt-4 md:mt-12 max-w-[1200px]">
        <x-email-optin-banner :user="auth()->user()"/>
    </div>

    <div class="container max-w-[1200px] mx-auto px-4 grid gap-4 mt-4 md:mt-8">
        <x-home.title>
            {{ __('Open RFCs') }}
        </x-home.title>

        <div class="grid lg:grid-cols-3 gap-5">
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

                        @if(isset($user) && $rfc->hasRfcVotedByUser($user))
                            @php
                                $argumentType = $rfc->userArgument($user)?->vote_type
                            @endphp

                            <x-tag @class([
                                'bg-none pl-1 pr-0',
                                'text-agree' => $argumentType?->isYes(),
                                'text-disagree' => $argumentType?->isNo(),
                            ])>
                                {{ __('You voted') }} {{ $argumentType->value }}
                            </x-tag>
                        @endif
                    </div>
                </x-card-link>
            @endforeach
        </div>
    </div>

    @if($argumentOfTheDay)
        <div class="container max-w-[1200px] mx-auto px-4 grid mt-4 md:mt-8 gap-4">
            <x-home.title>
                {{ __('Argument of the Day') }}
            </x-home.title>

            <x-argument-card.card
                :user="$argumentOfTheDay->user"
                :rfc="$argumentOfTheDay->rfc"
                :argument="$argumentOfTheDay"
                :readonly="true"
            />
        </div>
    @endif

@endcomponent
