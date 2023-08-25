@php
    /**
     * @var App\Models\User $user
     */
@endphp

<div
    x-show="open"
    x-cloak
    class="absolute dark:bg-secondary-dark-mode text-font dark:divide-secondary-dark-mode bg-white shadow-md rounded-md top-full mt-3 left-1/2 -translate-x-1/2 w-[170px] divide-y overflow-hidden"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 transform -translate-y-1"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform -translate-y-1"
>
    <x-profile.user-menu.dropdown-link href="{{ action(App\Http\Controllers\PublicProfileController::class, $user) }}">
        <x-icons.user class="w-5 h-5" />
        {{ __('My profile') }}
    </x-profile.user-menu.dropdown-link>

    <x-profile.user-menu.dropdown-link href="{{ action([App\Http\Controllers\ProfileController::class, 'edit']) }}">
        <x-icons.cog class="w-5 h-5" />
        {{ __('Settings') }}
    </x-profile.user-menu.dropdown-link>

    <x-profile.user-menu.dropdown-link onclick="document.getElementById('logout-form').submit()">
        <x-icons.logout class="w-5 h-5" />
        {{ __('Logout') }}
    </x-profile.user-menu.dropdown-link>
</div>

<form
    id="logout-form"
    class="hidden"
    action="{{ action([Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::class, 'destroy']) }}"
    method="post"
>
    @csrf
</form>
