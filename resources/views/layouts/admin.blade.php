@component('layouts.base')

    <div class="bg-admin-navbar-background text-font ">
        <div class="container mx-auto ">
            <nav class="py-3 px-6 md:px-2 flex items-center gap-8">
                <x-navbar.link
                    href="{{ action(\App\Http\Controllers\RfcAdminController::class) }}"
                    :isActive="request()->is('admin/rfc')">RFCs
                </x-navbar.link>

                <x-navbar.link
                        href="{{ action(\App\Http\Livewire\UserList::class) }}"
                        :isActive="request()->segment(2) == 'users'">Users
                </x-navbar.link>

                <x-navbar.link
                    href="{{ action(\App\Http\Controllers\VerificationRequestsAdminController::class) }}"
                    :isActive="request()->is('admin/verification-requests')">Verification Requests
                    @if($pendingVerificationRequests)
                        <span class="font-bold">({{ $pendingVerificationRequests }})</span>
                    @endif
                </x-navbar.link>
            </nav>
        </div>
    </div>

    {{ $slot }}
@endcomponent
