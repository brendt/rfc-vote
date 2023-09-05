@php
    /**
     * @var App\Models\ArgumentComment $comment
     */

@endphp

<div class="bg-input">
    <span class="font-bold">{{ $comment->user->name }}</span>

    <div class="whitespace-pre-line">{{ $comment->body }}</div>

    <div>
        {{ $comment->created_at->format('Y-m-d H:i') }}
    </div>
</div>