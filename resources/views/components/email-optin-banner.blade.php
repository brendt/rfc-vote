@if(! $user?->email_optin)
    @php
    $url = $user
        ? action(\App\Http\Controllers\EnableEmailOptinController::class, ['back' => request()->url()])
        : action(\App\Http\Controllers\LoginController::class)
    @endphp
    <div class="p-4 md:px-8 bg-purple-200 mb-4 md:mb-8 rounded-md md:rounded-full text-purple-900 font-bold">We've added email notifications. We'll email you when a new RFC is added so that you don't have to check the website manually. <a href="{{ $url }}" class="text-black underline hover:no-underline">Enable it here</a>.</div>
@endif
