@component('layouts.base')
    <nav class="p-4 flex items-center gap-4">
        <a href="{{ action(\App\Http\Controllers\RfcAdminController::class) }}">RFCs</a>
        <a href="{{ action(\App\Http\Controllers\VerificationRequestsAdminController::class) }}">Verification Requests</a>
    </nav>

    {{ $slot }}
@endcomponent
