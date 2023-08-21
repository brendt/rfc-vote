@php
    /**
     * @var App\Models\User $user
     */
@endphp

<div
    x-show="open"
    x-cloak
    class="absolute bg-white shadow-md text-gray-800 rounded-md top-full mt-2 left-1/2 -translate-x-1/2 w-full max-w-[180px] divide-y overflow-hidden"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 transform -translate-y-1"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform -translate-y-1"
>
    <x-profile.user-menu.dropdown-link href="{{ action(App\Http\Controllers\PublicProfileController::class, $user) }}">
        {{ __('My profile') }}
    </x-profile.user-menu.dropdown-link>

    <x-profile.user-menu.dropdown-link href="{{ action([App\Http\Controllers\ProfileController::class, 'edit']) }}">
        {{ __('Edit profile') }}
    </x-profile.user-menu.dropdown-link>
</div>
