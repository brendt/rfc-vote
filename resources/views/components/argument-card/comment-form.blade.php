<div class="flex gap-5 mt-7">
    <div>
        <img
            src="{{ $user->getAvatarUrl() }}"
            width="80"
            height="80"
            class="rounded-full shadow-md w-14 h-14"
        />
    </div>
    <div class="w-full">
        <h2 class="text-lg mb-1 lg:text-2xl font-bold text-gray-900 dark:text-white">
            Discussion ({{ $argument->comments->count() }})
        </h2>

        <form method="post">
            @csrf

            <textarea
                class="p-3 text-font bg-input ring-1 focus:ring-2 ring-transparent focus:border-purple-300 focus:ring-purple-500/50 focus:outline-none rounded-lg border border-divider w-full min-h-[110px]"
                placeholder="Write a comment ..."
            ></textarea>
        </form>
    </div>
</div>