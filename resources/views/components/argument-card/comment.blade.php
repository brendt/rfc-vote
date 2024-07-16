<div class="grid grid-cols-[50px_auto] gap-4 bg-input px-5 py-5 pb-3 border border-divider rounded-xl">
    <div>
        <img
            src="{{ $comment->user->getAvatarUrl() }}"
            width="80"
            height="80"
            class="rounded-full shadow-sm w-full"
        />
    </div>
    <div>
        <h2 class="text-lg text-font-second font-bold">{{ $comment->user->name }}</h2>

        <p class="whitespace-pre-line text-font-second opacity-90">{{ $comment->body }}</p>

        <div class="text-right">
            <small class="text-font opacity-70">
                {{ $comment->created_at->diffForHumans() }}
            </small>
        </div>
    </div>
</div>