@php
    /**
     * @var App\Models\User|null $user
     */
@endphp

<nav {{dusk('navbar')}} class="bg-main z-20 py-4 bg-gradient-to-r from-main to-main-light border-b border-divider">
    <div
        class="container flex justify-between text-white gap-4 items-center m-auto relative px-2"
        x-data="{ open: false }"
    >
        <div class="dark:text-gray-200 text-lg md:text-xl font-bold relative z-20">
            <a href="/">
                RFC Vote
                <span>{{ app()->isProduction() ? '' : ' (local)' }}</span>
            </a>
        </div>

        <x-navbar.mobile-menu-trigger />

        {{-- Overlay --}}
        <div
            x-cloak
            x-show="open"
            @click="open = false"
            class="bg-slate-900/60 fixed inset-0 z-10"
        ></div>

        <div
            {{dusk('navbar-navigation-links')}}
            class="md:flex justify-end md:items-center md:gap-6 font-bold text-sm md:text-md inset-x-2 top-14 z-10"
            :class="open ? 'flex absolute bg-white dark:bg-main-light text-font flex-col rounded-xl shadow-lg text-[1.1em] py-8 px-4' : 'hidden gap-4'"
            x-cloak
        >
            <x-navbar.link
                href="{{ action(App\Http\Controllers\HomeController::class) }}"
                :isActive="request()->is('/')"
            >
                Open RFCs
            </x-navbar.link>

            <x-navbar.link
                href="{{ action(App\Http\Controllers\AboutController::class) }}"
                :isActive="request()->is('about')"
            >
                About
            </x-navbar.link>

            @if($user)
                @if($user->is_admin)
                    <x-navbar.link
                        href="{{ action(App\Http\Controllers\RfcAdminController::class) }}"
                        :isActive="request()->is('admin/*')"
                    >
                        Admin
                    </x-navbar.link>
                @endif

                <x-navbar.messages-link :user="$user" />
                <x-profile.user-menu.menu :user="$user" />
            @else
                <x-navbar.link
                    href="{{ action(App\Http\Controllers\LoginController::class) }}"
                    :isActive="request()->is('login')"
                >
                    Login
                </x-navbar.link>

                <x-navbar.link
                    href="{{ action(App\Http\Controllers\RegisterController::class) }}"
                    :isActive="request()->is('register')"
                >
                    Register
                </x-navbar.link>
            @endif

            <x-navbar.dark-mode-button />
        </div>
    </div>
</nav>
