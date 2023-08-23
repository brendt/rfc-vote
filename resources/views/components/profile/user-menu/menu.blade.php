@php
    /**
     * @var App\Models\User $user
     */
@endphp

<div
    x-data="{ open: false }"
    class="relative mt-9 md:mt-0 w-full md:w-auto "
>
    {{-- Trigger button --}}
    <button
        type="button"
        class="flex gap-3 items-center dark:bg-primary-dark-mode dark:hover:bg-main-dark bg-purple-900 hover:bg-gray-800 group transition-colors pr-5 md:pr-0 pl-5 rounded-full text-white py-2 md:py-0 mx-auto md:mx-0"
        @click="open = !open"
        @click.away="open = false"
    >
        <span class="front-bold">{{ $user->username }}</span>

        @if($user->getAvatarUrl())
            <img
                src="{{ $user->getAvatarUrl() }}"
                class="rounded-full w-8 h-8 transition-transform group-hover:scale-110"
                alt="{{ $user->name }} user avatar"
            />
        @endif
    </button>

    <x-profile.user-menu.dropdown :user="$user" />
</div>
