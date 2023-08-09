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
    <meta name="twitter:card" content="article">
    <meta name="twitter:creator" content="@brendt_gd"/>
    HTML,
])
    <div class="container mx-auto px-4 grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-12 mt-4 md:mt-12 max-w-[1200px] mb-8">
        <div class="col-span-3">
            <h1 class="font-mono text-3xl font-bold col-span-3 flex justify-center gap-2 md:gap-4 items-center">
                <span>{{ $rfc->title }}</span>
                <a
                    href="{{ $rfc->url }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="text-xs bg-[#7a86b8] border border-[#4f5b93] hover:bg-[#4f5b93] text-white p-2 py-1 font-bold rounded min-w-[80px] text-center"
                >Read RFC</a>

                @if($user?->is_admin)
                    <a
                        href="{{ action([\App\Http\Controllers\RfcEditController::class, 'edit'], ['rfc' => $rfc, 'back' => action(\App\Http\Controllers\RfcDetailController::class, $rfc)]) }}"
                        class="text-xs bg-blue-100 border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white p-2 py-1 font-bold rounded text-center"
                    >Edit</a>
                @endif
            </h1>

            <p class="mt-2 md:mt-4 md:max-w-[50%] md:text-center md:mx-auto">
                {{ $rfc->description }}
            </p>
        </div>

        <div class="col-span-3">
            <livewire:vote-bar :rfc="$rfc->withoutRelations()" :user="$user?->withoutRelations()"/>
        </div>

        @if($user)
            <div class="col-span-3">
                <livewire:argument-form :rfc="$rfc->withoutRelations()" :user="$user->withoutRelations()"/>
            </div>
        @endif

        <div class="col-span-3">
            <livewire:argument-list :rfc="$rfc" :user="$user"/>
        </div>
    </div>
@endcomponent
