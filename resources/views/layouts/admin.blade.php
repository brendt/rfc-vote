@component('layouts.base')

<nav class="bg-gray-800 fixed inset-y-0 w-14 hover:w-72 flex flex-col opacity-80 hover:opacity-95 z-10 pt-16 divide-y divide-gray-600 overflow-hidden shadow-md transition-all">
    <x-admin-sidebar.link
        href="{{ action(\App\Http\Controllers\RfcAdminController::class) }}"
        :isActive="request()->is('admin/rfc')"
    >
        <x-icons.rectangle-stack class="w-6 h-6" />
        RFCs
    </x-admin-sidebar.link>

    <x-admin-sidebar.link
        href="{{ action(\App\Http\Livewire\UserList::class) }}"
        :isActive="request()->segment(2) == 'users'"
    >
        <x-icons.users class="w-6 h-6" />
        Users
    </x-admin-sidebar.link>

    <x-admin-sidebar.link
        href="{{ action(\App\Http\Controllers\VerificationRequestsAdminController::class) }}"
        :isActive="request()->is('admin/verification-requests')"
    >
        <x-icons.check-circle class="w-6 h-6" />
        Verification Requests

        @if($pendingVerificationRequests)
            <span class="font-bold">({{ $pendingVerificationRequests }})</span>
        @endif
    </x-admin-sidebar.link>
</nav>

<div class="pl-9 md:pl-14">
    {{ $slot }}
</div>

@endcomponent
