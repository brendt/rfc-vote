@php
    /**
     * @var App\Models\Message $message
     */
@endphp

<div
    class="absolute right-2 top-2"
    x-data="{ open: false }"
>
    <button
        type="button"
        class="p-1 rounded-full group-hover:bg-gray-100 hover:bg-gray-100 transition-colors"
        @click="open = !open"
        @click.away="open = false"
    >
        <x-icons.ellipsis-vertical class="w-7 h-7 text-gray-800" />
    </button>

    <div
        x-cloak
        x-show="open"
        class="bg-white rounded-md border right-5 absolute divide-divide divide-y w-[180px] shadow-md"
    >
        @if(! $message->isArchived())
            @if($message->isUnread() || $message->isArchived())
                <x-message-card.option wire:click="read({{ $message->id }})">
                    <x-icons.check class="w-4 h-4"/> Mark as read
                </x-message-card.option>
            @endif

            @if(! $message->isUnread())
                <x-message-card.option wire:click="unread({{ $message->id }})">
                    <x-icons.eye class="w-4 h-4"/> Mark as unread
                </x-message-card.option>
            @endif

            <x-message-card.option wire:click="archive({{ $message->id }})">
                <x-icons.archive class="w-4 h-4"/> Archive
            </x-message-card.option>
        @else
            <x-message-card.option wire:click="unread({{ $message->id }})">
                <x-icons.archive-remove class="w-4 h-4"/> Unarchive
            </x-message-card.option>
        @endif
    </div>
</div>
