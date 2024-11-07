@if(! $user?->email_optin)
    @php
        $url = $user
            ? action(App\Http\Controllers\EnableEmailOptinController::class, ['back' => request()->url()])
            : action(App\Http\Controllers\LoginController::class)
    @endphp

    <x-success-message class="mb-10">
        Stay updated! Get an email whenever a new RFC is added.

        <a href="{{ $url }}" class="font-bold text-font-second hover:text-font underline">
            Enable notifications
        </a>
    </x-success-message>
@endif
