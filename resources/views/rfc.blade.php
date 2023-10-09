@php
    $metaImageUrl = action(App\Http\Controllers\RfcMetaImageController::class, $rfc);
@endphp

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
@endpush

@push('scripts')
    <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
@endpush

@component('layouts.base', [
    'pageTitle' => $rfc->title . ' - RFC Vote',
    'showToTopArrow' => true,
])
    <div class="container mx-auto px-4 mt-5 max-w-[1200px] mb-8">
        <x-email-optin-banner :user="$user"/>

        <div class="grid gap-4 bg-rfc-card p-7 md:px-14 md:py-12 rounded-xl">
            <h1 class="text-2xl md:text-4xl font-bold text-font-second">
                {{ $rfc->title }}
            </h1>

            <div class="flex justify-start text-xs items-center  flex-wrap gap-2 border-divider border-b pb-6 mb-2">
                <x-tag
                    :href="$rfc->url"
                    target="_blank"
                    class="bg-[#555f88] text-white"
                >
                    <x-icons.external-link class="w-4 h-4" />
                    Read the RFC
                </x-tag>

                @if($rfc->externals_url)
                    <x-tag
                        :href="$rfc->externals_url"
                        target="_blank"
                        class="bg-[#555f88] text-white"
                    >
                        <x-icons.external-link class="w-4 h-4" />
                        Externals
                    </x-tag>
                @endif

                <x-tag>
                    <x-icons.chat-bubble class="w-4 h-4" />
                    {{ $rfc->arguments->count() }}
                </x-tag>

                <livewire:rfc-counter :rfc="$rfc" :vote-type="App\Models\VoteType::YES"/>
                <livewire:rfc-counter :rfc="$rfc" :vote-type="App\Models\VoteType::NO" />

                @if($user?->is_admin)
                    <x-tag
                        :href="action([App\Http\Controllers\RfcEditController::class, 'edit'], ['rfc' => $rfc, 'back' => action(App\Http\Controllers\RfcDetailController::class, $rfc)])"
                        class="bg-blue-100"
                    >
                        <x-icons.pen class="w-4 h-4" />
                        Edit
                    </x-tag>
                @endif
            </div>

            <x-markdown class="prose text-lg text-font max-w-full">
                {!! $rfc->description !!}
            </x-markdown>

            @if(!$user || $user->shouldSeeTutorial())
                <x-rfc.tutorial />
            @endif
        </div>

        <div class="col-span-3 mt-4 md:mt-8">
            <livewire:vote-bar :rfc="$rfc" :user="$user"/>
        </div>

        <div class="col-span-3 mt-4 md:mt-8 md:px-8">
            <livewire:argument-list :rfc="$rfc" :user="$user"/>
        </div>

        <div class="mt-12 md:px-8">
            <h2 class="text-2xl font-bold text-font-second tracking-wide md:mb-1">
                Check out another RFCs
            </h2>
            <div class="flex flex-col justify-center lg:flex-row mt-4 space-x-0 space-y-4 lg:space-x-4 lg:space-y-0">
                @foreach($additionalRfcs as $additionalRfc)
                    <x-card-link :to="action(App\Http\Controllers\RfcDetailController::class, $additionalRfc)">
                        <div class="text-xl text-font font-bold px-2 border-b pb-4 mb-2">
                            {{ $additionalRfc->title }}
                        </div>

                        <x-markdown class="px-2 text-font">{!! $additionalRfc->teaser !!}</x-markdown>

                        <div class="flex flex-wrap justify-start text-xs mt-3 gap-2 uppercase items-center">
                            <x-tag class="font-bold">
                                <x-icons.chat-bubble class="w-4 h-4"/>
                                {{ $additionalRfc->arguments->count() }}
                            </x-tag>

                            <livewire:rfc-counter :rfc="$additionalRfc" :vote-type="App\Models\VoteType::YES"/>
                            <livewire:rfc-counter :rfc="$additionalRfc" :vote-type="App\Models\VoteType::NO"/>
                        </div>
                    </x-card-link>
                @endforeach
            </div>
        </div>
    </div>
@endcomponent
