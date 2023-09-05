@php
    /**
     * @var App\Models\ArgumentComment $comment
     */

@endphp

<div class="flex gap-4 bg-input p-5 shadow-md rounded-lg">
    <div class="w-20">
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