@php
/** @var \App\Models\Message $message */
@endphp

<div class="
            border-2 border-transparent
            {{ $message->isUnread() ? 'border-purple-200' : '' }}
            bg-white rounded-xl shadow-md w-full group/card py-5 pl-4 pr-10 md:px-8 md:pt-7 flex gap-6 items-center relative
        ">
    <div class="grid gap-2 md:gap-4 w-full">
        {{ $message->body }}

        <div class="flex flex-col lg:flex-row gap-4 items-center justify-between mb-3 mt-1 opacity-80 border-t pt-3">
            <div class="text-xs">
                @if(! $message->isArchived())
                    @if($message->isUnread() || $message->isArchived())
                        <x-buttons.ghost wire:click="read({{ $message->id }})">
                            <x-icons.check class="w-4 h-4"/> Mark as read
                        </x-buttons.ghost>
                    @endif

                    @if(! $message->isUnread())
                        <x-buttons.ghost wire:click="unread({{ $message->id }})">
                            <x-icons.eye class="w-4 h-4"/> Mark as unread
                        </x-buttons.ghost>
                    @endif

                    <x-buttons.ghost wire:click="archive({{ $message->id }})">
                        <x-icons.archive class="w-4 h-4"/> Archive
                    </x-buttons.ghost>
                @else
                    <x-buttons.ghost wire:click="unread({{ $message->id }})">
                        <x-icons.archive-remove class="w-4 h-4"/> Unarchive
                    </x-buttons.ghost>
                @endif
            </div>

            <div class="flex items-end gap-2">
                <small class="flex items-center gap-2">
                    From <x-profile.username :user="$message->sender"/>
                </small>

                <span class="hidden md:block">•</span>

                <small>
                    Sent at {{ $message->created_at->format('Y-m-d H:i') }}
                </small>
            </div>
        </div>
    </div>
</div>
