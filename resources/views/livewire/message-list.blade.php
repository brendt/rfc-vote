<div>
    <h2 class="text-2xl text-gray-700 font-bold mb-4">Inbox</h2>

    <div class="grid gap-4">
        @foreach($user->inboxMessages as $message)
            <x-message-card.card :message="$message" />
        @endforeach

        @if($user->inboxMessages->isEmpty())
            <p>Inbox 0!</p>
        @endif

        @if($user->archivedMessages->isNotEmpty())
            <h2 class="text-lg font-bold mb-2 mt-6">Archive</h2>

            @foreach($user->archivedMessages as $message)
                <x-message-card.card :message="$message" />
            @endforeach
        @endif
    </div>
</div>
