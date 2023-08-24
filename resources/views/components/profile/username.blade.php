@if ($user)
    <x-profile.flair :user="$user" />

    <a
        href="{{ action(App\Http\Controllers\PublicProfileController::class, $user) }}"
        class="flex items-center gap-1.5 group/username"
    >
        <img
            src="{{ $user->getAvatarUrl() }}"
            class="rounded-full shadow-sm w-[20px] h-[20px]"
            alt="{{ $user->username }} avatar"
        />

        <div class="group-hover/username:underline">{{ \Illuminate\Support\Str::limit($user->username, 18) }}</div>
    </a>
@endif
