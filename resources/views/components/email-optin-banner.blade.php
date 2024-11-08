@use('App\Http\Controllers\EnableEmailOptinController')
@use('App\Http\Controllers\LoginController')

@if(! $user?->email_optin)
    @php
        $url = $user
            ? action(EnableEmailOptinController::class, ['back' => request()->url()])
            : action(LoginController::class)
    @endphp

    <x-success-message class="mb-10">
        {{ EnableEmailOptinController::STAY_UPDATED_MESSAGE }}

        <a href="{{ $url }}" class="font-bold text-font-second hover:text-font underline">
            {{ EnableEmailOptinController::BUTTON_MESSAGE }}
        </a>
    </x-success-message>
@endif
