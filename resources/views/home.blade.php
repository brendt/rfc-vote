@component('layouts.base')

<div class="container mx-auto px-4 grid lg:grid-cols-3 gap-6 md:gap-12 mt-4 md:mt-8">
    @foreach ($rfcs as $rfc)
        <a href="{{ action(\App\Http\Controllers\RfcDetailController::class, $rfc) }}">
            {{ $rfc->title }}
        </a>
        <p>{{ $rfc->description }}</p>
    @endforeach
</div>

@endcomponent
