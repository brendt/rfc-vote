@php
    /**
     * @var App\Models\User|null $user
     */
@endphp

<nav class="bg-main z-10 p-4 bg-gradient-to-r from-main to-main-light">
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

                <x-navbar.link
                    href="{{ action(\App\Http\Controllers\MessagesController::class) }}"
                    :isActive="request()->is('messages')"
                >
                    <span class="flex gap-1">
                        <x-icons.inbox class="w-5 h-5" />
                        <span class="md:hidden">
                            Messages (</span>{{ $user->unread_message_count >= 1 ? $user->unread_message_count : 0 }}
                        <span class="md:hidden">)</span>
                    </span>
                </x-navbar.link>

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