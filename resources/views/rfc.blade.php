@php
    $metaImageUrl = action(App\Http\Controllers\RfcMetaImageController::class, $rfc);
@endphp

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/highlight.js/latest/styles/github.min.css">
@endpush

@push('scripts')
    <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
    <script src="https://cdn.jsdelivr.net/highlight.js/latest/highlight.min.js"></script>
@endpush

@component('layouts.base', [
    'pageTitle' => $rfc->title . ' - ' . __('RFC Vote'),
    'showToTopArrow' => true,
])
    <div class="container mx-auto px-4 mt-5 max-w-[1200px] mb-8">
        <x-email-optin-banner :user="$user"/>

        <div class="grid gap-4 bg-white p-7 md:px-14 md:py-12 rounded-xl">
            <h1 class="text-2xl md:text-4xl font-bold text-gray-800">
                {{ $rfc->title }}
            </h1>

            <div class="flex justify-start text-xs items-center flex-wrap gap-2 border-b pb-6 mb-2">
                <x-tag
                    :href="$rfc->url"
                    target="_blank"
                    class="bg-[#6b77a6] hover:bg-[#555f88] text-white"
                >
                    <x-icons.external-link class="w-4 h-4" />
                    {{ __('Read the RFC') }}
                </x-tag>

                <x-tag>
                    <x-icons.chat-bubble class="w-4 h-4" />
                    {{ $rfc->arguments->count() }}
                </x-tag>

                <livewire:rfc-counter :rfc="$rfc" :vote-type="App\Models\VoteType::YES"/>
                <livewire:rfc-counter :rfc="$rfc" :vote-type="App\Models\VoteType::NO" />

                @if($user?->is_admin)
                    <x-tag
                        :href="action([App\Http\Controllers\RfcEditController::class, 'edit'], ['rfc' => $rfc, 'back' => action(\App\Http\Controllers\RfcDetailController::class, $rfc)])"
                        class="bg-blue-100 hover:bg-blue-200"
                    >
                        <x-icons.pen class="w-4 h-4" />
                        {{ __('Edit') }}
                    </x-tag>
                @endif
            </div>

            <x-markdown class="prose text-lg max-w-full">
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
    </div>
@endcomponent
