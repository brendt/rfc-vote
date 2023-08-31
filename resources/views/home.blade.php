@component('layouts.base')
    <div class="container max-w-[1200px] mx-auto px-4 grid gap-4 my-10">
        <div class="px-4 max-w-[1200px]">
            <x-email-optin-banner :user="auth()->user()"/>
        </div>

        <x-home.title id="open-rfcs-title">
            {{ __('Open RFCs') }}
        </x-home.title>

        <div class="grid lg:grid-cols-3 gap-5">
            @foreach ($rfcs as $rfc)
                <x-card-link :href="action(App\Http\Controllers\RfcDetailController::class, $rfc)">
                    <div class="text-xl font-bold px-2 border-divider border-b pb-4 mb-2 text-font">
                        {{ $rfc->title }}
                    </div>

                    <x-markdown class="px-2 text-font markdown-text">{!! $rfc->teaser !!}</x-markdown>

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

        @if($argumentOfTheDay)
            <x-home.title id="argument-of-the-day-title">
                {{ __('Argument of the Day') }}
            </x-home.title>

            <x-argument-card.card
                :user="$argumentOfTheDay->user"
                :rfc="$argumentOfTheDay->rfc"
                :argument="$argumentOfTheDay"
                :readonly="true"
            />
        @endif
    </div>

@endcomponent
