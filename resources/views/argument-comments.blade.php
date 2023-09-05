
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/highlight.js/latest/styles/github.min.css">
@endpush

@push('scripts')
    <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
    <script src="https://cdn.jsdelivr.net/highlight.js/latest/highlight.min.js"></script>
@endpush

@component('layouts.base', [
    'pageTitle' => $rfc->title . ' - ' . __('RFC Vote'),
    'showToTopArrow' => true,
])
    <div class="container mx-auto px-4 mt-5 max-w-[1200px] mb-8">
        <x-argument-card.card
            :user="$user"
            :rfc="$rfc"
            :argument="$argument"
            :readonly="true"
        />

        <div class="space-y-4 mt-4">
            @foreach($argument->comments as $comment)
                <x-argument-card.comment :comment="$comment" />
            @endforeach
        </div>
    </div>
@endcomponent
