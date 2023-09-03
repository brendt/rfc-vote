@php
    /**
     * @var App\Models\User $user
     */
@endphp

<div class="flex flex-col md:flex-row gap-6 justify-between items-center">
    <div class="flex gap-5">
        <div>
            <img
                src="{{ $user->getAvatarUrl() }}"
                class="rounded-full shadow-md w-[100px]"
                alt="{{ $user->username }}'s avatar"
            />
        </div>

        <div>
            <h1 class="text-3xl font-bold text-font">
                {{ $user->name }}
            </h1>

            <h2 class="text-xl font-bold text-font-second">
                {{ $user->username }}
            </h2>

            <p class="text-font-second">
                {{ __('Member since') }}

                <time datetime="{{ $user->created_at->format('c') }}" title="{{ $user->created_at->format('c') }}">
                    {{ $user->created_at->diffForHumans() }}
                </time>
            </p>

            <x-profile.social :user="$user" />

            <x-profile.flair :user="$user" />
        </div>
    </div>

    <div class="w-full md:w-auto">
        <div class="flex gap-5 overflow-auto pb-4">
            <x-profile.header-block
                :value="number_format($user->reputation)"
                :label="__('Total Reputation')"
            >
                <x-icons.trophy class="w-full dark:text-font" />
            </x-profile.header-block>

            <x-profile.header-block
                :value="number_format($user->arguments_count)"
                :label="__('Total Arguments')"
            >
                <x-icons.chat-bubble class="w-full dark:text-font" />
            </x-profile.header-block>

            <x-profile.header-block
                :value="number_format($user->argument_votes_count)"
                :label="__('Total Votes for Arguments')"
            >
                <x-icons.arrow-up-empty class="w-full dark:text-font" />
            </x-profile.header-block>
        </div>
    </div>
</div>
