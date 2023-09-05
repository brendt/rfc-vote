<div class="grid grid-cols-[50px_auto] gap-5">
    <div>
        <img
            src="{{ $user->getAvatarUrl() }}"
            width="80"
            height="80"
            class="rounded-full shadow-md w-full mt-2"
        />
    </div>

    <div class="w-full">
        <h2 class="text-lg mb-1 lg:text-2xl font-bold text-gray-900 dark:text-white opacity-80">
            Discussion ({{ $argument->comments->count() }})
        </h2>

        <form method="post">
            @csrf

            <textarea
                @class([
                    'p-3 text-font bg-input ring-1 focus:ring-2 ring-transparent rounded-lg',
                    'focus:ring-2 ring-transparent focus:border-purple-300 focus:ring-purple-500/50 focus:outline-none',
                    'border border-divider w-full min-h-[110px]',
                ])
                placeholder="Write a comment ..."
            ></textarea>

            <x-buttons.main class="mt-2" type="submit">
                Comment
            </x-buttons.main>
        </form>
    </div>
</div>