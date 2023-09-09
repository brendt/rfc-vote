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
    <div class="container mx-auto p-3 md:p-8">
        <div class="flex justify-start items-start gap-2 mb-2">
            <x-buttons.main-small :href=" action(\App\Http\Controllers\RfcDetailController::class, $argument->rfc) ">
                Back
            </x-buttons.main-small>

            <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white opacity-80 mb-2">
                {{ $argument->rfc->title }}: argument by {{ $argument->user->name }}
            </h2>
        </div>

        <x-argument-card.card
            :user="$user"
            :rfc="$rfc"
            :argument="$argument"
            :readonly="true"
        />

        <div class="max-w-[900px] mt-6 md:mt-9 mx-auto">
            <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white opacity-80 mb-2">
                Comments ({{ $argument->comments->count() }})
            </h2>

            <div class="space-y-4">
                @foreach($argument->comments as $comment)
                    <x-argument-card.comment :comment="$comment" />
                @endforeach
            </div>

            <div class="mt-6  md:mt-8">
                <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white opacity-80 mb-2">
                    Add a new comment
                </h2>

                <x-argument-card.comment-form
                    :user="$user"
                    :argument="$argument"
                />
            </div>
        </div>
    </div>
@endcomponent
