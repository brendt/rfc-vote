@php
    /**
     * @var App\Models\Message $message
     */
@endphp

<div
    @class([
        'border-2 bg-white rounded-xl shadow-md w-full',
        'border-purple-400' => $message->isUnread(),
        'border-transparent' => ! $message->isUnread(),
        'group/card py-5 pl-6 pr-10 flex gap-6 items-center relative',
    ])
>
    <x-message-card.options :message="$message" />

    <div class="grid gap-2 md:gap-4 w-full">
        <p>{{ $message->body }}</p>

        <div class="flex flex-col lg:flex-row gap-4 items-center justify-end mt-1 border-t pt-3">
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
