@php
    /**
     * @var App\Models\User $user
     */
@endphp

<div class="flex gap-2 items-center mt-1.5 mb-4">
    <x-profile.social-link :url="$user->website_url">
        <x-icons.globe class="w-5 h-5" />
    </x-profile.social-link>

    <x-profile.social-link :url="$user->github_url">
        <x-icons.github class="w-5 h-5" />
    </x-profile.social-link>

    <x-profile.social-link :url="$user->twitter_url">
        <x-icons.x class="w-5 h-5" />
    </x-profile.social-link>
</div>
