<div class="grid grid-cols-[50px_auto] gap-5">
    <div>
        <img
            src="{{ $user?->getAvatarUrl() ?? asset('default-avatar.jpg') }}"
            width="80"
            height="80"
            class="rounded-full shadow-md w-full mt-2"
        />
    </div>

    <div class="w-full">
        <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white opacity-80 mb-2">
            Add a new comment
        </h2>

        <form method="post" action="{{ action(\App\Http\Controllers\CreateArgumentCommentController::class, $argument) }}">
            @csrf

            <textarea
                name="body"
                @class([
                    'p-3 text-font bg-input ring-1 focus:ring-2 ring-transparent rounded-lg',
                    'focus:ring-2 ring-transparent focus:border-purple-300 focus:ring-purple-500/50 focus:outline-none',
                    'border border-divider w-full min-h-[110px]',
                    'opacity-80 cursor-not-allowed' => !$user,
                ])
                placeholder="{{ $user ? 'Write a comment ...' : 'You need to be logged in to comment!' }}"
                @disabled(!$user)
            ></textarea>

            <x-buttons.main
                class="mt-2"
                type="submit"
                :disabled="!$user"
            >
                Comment
            </x-buttons.main>
        </form>
    </div>
</div>
