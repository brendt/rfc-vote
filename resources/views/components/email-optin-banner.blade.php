@if(! $user?->email_optin)
    @php
        $url = $user
            ? action(App\Http\Controllers\EnableEmailOptinController::class, ['back' => request()->url()])
            : action(App\Http\Controllers\LoginController::class)
    @endphp

    <x-success-message class="mb-10">
        {{ __("We've added email notifications. We'll email you when a new RFC is added so that you don't have to check the website manually.") }}
        <br />

        <a href="{{ $url }}" class="font-bold text-font-second hover:text-font underline">
            {{ __('Enable it here') }}
        </a>
    </x-success-message>
@endif
