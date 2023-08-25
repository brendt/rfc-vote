<div class="grid gap-2">
    <h2 class="text-lg font-bold">Inbox</h2>

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