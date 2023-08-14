@php
    $metaImageUrl = action(\App\Http\Controllers\RfcMetaImageController::class, $rfc);
@endphp

@component('layouts.base', [
    'meta' => <<<HTML
    <meta property="og:type" content="article">

    <meta name="title" content="$rfc->title">
    <meta name="twitter:title" content="$rfc->title">
    <meta property="og:title" content="$rfc->title">
    <meta itemprop="name" content="$rfc->title">

    <meta name="description" content="$rfc->description">
    <meta name="twitter:description" content="$rfc->description">
    <meta property="og:description" content="$rfc->description">
    <meta itemprop="description" content="$rfc->description">

    <meta property="og:image" content="$metaImageUrl"/>
    <meta property="twitter:image" content="$metaImageUrl"/>
    <meta name="image" content="$metaImageUrl"/>

    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:creator" content="@brendt_gd"/>
    HTML,
])
    <div
        class="container mx-auto px-4 grid grid-cols-1 gap-6 md:gap-8 mt-4 md:mt-12 max-w-[1200px] mb-8"
    >
        <div class="grid gap-4 md:px-8">
            <h1 class="text-4xl font-bold">
                {{ $rfc->title }}
            </h1>

            <div class="flex justify-start text-xs items-center flex-wrap gap-1">
                <x-tag-link
                    :href="$rfc->url"
                    target="_blank"
                    class="bg-[#7a86b8] border font-bold hover:bg-[#4f5b93] text-white"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                         class="w-4 h-4 text-inherit">
                        <path fill-rule="evenodd"
                              d="M15.75 2.25H21a.75.75 0 01.75.75v5.25a.75.75 0 01-1.5 0V4.81L8.03 17.03a.75.75 0 01-1.06-1.06L19.19 3.75h-3.44a.75.75 0 010-1.5zm-10.5 4.5a1.5 1.5 0 00-1.5 1.5v10.5a1.5 1.5 0 001.5 1.5h10.5a1.5 1.5 0 001.5-1.5V10.5a.75.75 0 011.5 0v8.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V8.25a3 3 0 013-3h8.25a.75.75 0 010 1.5H5.25z"
                              clip-rule="evenodd"/>
                    </svg>

                    Read the RFC
                </x-tag-link>

                <x-tag class="font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                         class="w-4 h-4 text-gray-700">
                        <path fill-rule="evenodd"
                              d="M4.804 21.644A6.707 6.707 0 006 21.75a6.721 6.721 0 003.583-1.029c.774.182 1.584.279 2.417.279 5.322 0 9.75-3.97 9.75-9 0-5.03-4.428-9-9.75-9s-9.75 3.97-9.75 9c0 2.409 1.025 4.587 2.674 6.192.232.226.277.428.254.543a3.73 3.73 0 01-.814 1.686.75.75 0 00.44 1.223zM8.25 10.875a1.125 1.125 0 100 2.25 1.125 1.125 0 000-2.25zM10.875 12a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0zm4.875-1.125a1.125 1.125 0 100 2.25 1.125 1.125 0 000-2.25z"
                              clip-rule="evenodd"/>
                    </svg>

                    {{ $rfc->arguments->count() }}
                </x-tag>

                <livewire:rfc-counter :rfc="$rfc" :vote-type="\App\Models\VoteType::YES"></livewire:rfc-counter>
                <livewire:rfc-counter :rfc="$rfc" :vote-type="\App\Models\VoteType::NO"></livewire:rfc-counter>

                @if($user?->is_admin)
                    <x-tag-link
                        :href="action([\App\Http\Controllers\RfcEditController::class, 'edit'], ['rfc' => $rfc, 'back' => action(\App\Http\Controllers\RfcDetailController::class, $rfc)])"
                        class="bg-blue-300 hover:bg-blue-500 hover:text-white text-blue-900 font-bold"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                             fill="currentColor" class="w-4 h-4 text-inherit">
                            <path
                                d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z"/>
                            <path
                                d="M5.25 5.25a3 3 0 00-3 3v10.5a3 3 0 003 3h10.5a3 3 0 003-3V13.5a.75.75 0 00-1.5 0v5.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V8.25a1.5 1.5 0 011.5-1.5h5.25a.75.75 0 000-1.5H5.25z"/>
                        </svg>

                        Edit
                    </x-tag-link>
                @endif
            </div>

            <x-markdown class="prose">
                {!! $rfc->description !!}
            </x-markdown>
        </div>

        <div class="col-span-3">
            <livewire:vote-bar :rfc="$rfc" :user="$user"/>
        </div>

        <div class="col-span-3  md:px-8">
            <livewire:argument-list :rfc="$rfc" :user="$user"/>
        </div>
    </div>
@endcomponent
