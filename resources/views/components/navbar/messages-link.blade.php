@php
    /**
     * @var App\Models\User|null $user
     */
@endphp

<x-navbar.link
    href="{{ action(\App\Http\Controllers\MessagesController::class) }}"
    :is-active="request()->is('messages')"
>
    <span>
        <x-icons.inbox class="w-5 h-5 hidden md:block" />
        <span class="md:hidden">Messages</span>
    </span>

    {{-- Small notification bubble --}}
    @if ($user->unread_message_count > 0)
        <span class="md:absolute ml-1 md:ml-0 -top-1 -right-1 bg-red-500 text-white text-xs rounded-full min-w-[16px] h-[16px] inline-flex items-center justify-center p-0.5">
            {{ $user->unread_message_count }}
        </span>
    @endif
</x-navbar.link>