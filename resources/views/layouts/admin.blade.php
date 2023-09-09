@component('layouts.base')

<nav class="bg-gray-800 fixed inset-y-0 flex flex-col opacity-70 z-10 pt-20 divide-y divide-gray-500 transition-all overflow-hidden">
    <x-admin-sidebar.link
        href="{{ action(\App\Http\Controllers\RfcAdminController::class) }}"
        :isActive="request()->is('admin/rfc')">RFCs
    </x-admin-sidebar.link>

    <x-admin-sidebar.link
        href="{{ action(\App\Http\Livewire\UserList::class) }}"
        :isActive="request()->segment(2) == 'users'">Users
    </x-admin-sidebar.link>

    <x-admin-sidebar.link
        href="{{ action(\App\Http\Controllers\VerificationRequestsAdminController::class) }}"
        :isActive="request()->is('admin/verification-requests')"
    >
        Verification Requests

        @if($pendingVerificationRequests)
            <span class="font-bold">({{ $pendingVerificationRequests }})</span>
        @endif
    </x-admin-sidebar.link>
</nav>

{{ $slot }}

@endcomponent
