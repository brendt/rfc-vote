@component('layouts.base')

<x-admin-sidebar.sidebar :pending-verification-requests="$pendingVerificationRequests" />

<div class="pl-9 md:pl-12">
    {{ $slot }}
</div>

@endcomponent
