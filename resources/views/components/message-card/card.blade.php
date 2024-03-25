@php
    /**
     * @var App\Models\Message $message
     */
@endphp

<div
    @class([
        'border-2 rounded-xl w-full bg-message-card text-font',
        'border-purple-400 dark:border-gray-500' => $message->isUnread(),
        'border-transparent shadow-md' => ! $message->isUnread(),
        'group/card py-5 pl-6 pr-10 flex gap-6 items-center relative',
    ])
>
    <x-message-card.options :message="$message" />

    <div class="grid gap-2 md:gap-4 w-full">
        <p class="whitespace-pre-line">{{ $message->body }}</p>

        <div class="flex flex-col lg:flex-row gap-4 items-center justify-between mt-1 border-divider border-t pt-3">
            <div class="text-xs">
                @if($message->url)
                    <x-buttons.ghost :href="action(\App\Http\Controllers\ViewMessageController::class, $message)">View</x-buttons.ghost>
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
