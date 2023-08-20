@php
    /**
     * @var App\Models\User $user
     */
@endphp

<div class="flex gap-6 justify-between items-center">
    <div class="flex gap-5">
        <div>
            <img
                src="{{ $user->getAvatarUrl() }}"
                class="rounded-full shadow-md w-[100px]"
                alt="{{ $user->username }}'s avatar"
            />
        </div>

        <div>
            <h1 class="text-3xl font-bold">
                {{ $user->name }}
            </h1>

            <h2 class="text-xl text-gray-500 font-bold">
                {{ $user->username }}
            </h2>

            <p class="text-gray-500">
                {{ __('Member since') }} {{ $user->created_at->diffForHumans() }}
            </p>

            <x-profile.social :user="$user" />
        </div>
    </div>
</div>
