<x-form.wrapper
    action="{{ action([App\Http\Controllers\ProfileController::class, 'update']) }}"
    method="post"
    enctype="multipart/form-data"
    heading="Profile"
>
    <div class="col-span-2">
        <x-form.input
            type="text"
            name="name"
            label="Name"
            value="{{ $user->name ?? old('name') }}"
        />
    </div>

    <div class="col-span-2 mt-4">
        <x-form.input
            type="text"
            name="username"
            label="Username"
            value="{{ $user->username ?? old('username') }}"
        />
    </div>

    <div class="flex gap-4 items-center my-4">
        @if ($user->getAvatarUrl())
            <img
                src="{{ $user->getAvatarUrl() }}"
                class="shadow-xl rounded-full"
                width="80"
                height="80"
                alt="Your avatar"
            />
        @endif

        <x-form.input type="file" name="avatar" label="Choose a new avatar" />
    </div>

    <div class="col-span-2 mt-6">
        <h2 class="text-xl font-bold mb-2">Social links</h2>

        <div class="space-y-3">
            <x-form.input
                type="text"
                name="website_url"
                label="Website"
                value="{{ $user->website_url ?? old('website_url') }}"
            />
            <x-form.input
                type="text"
                name="github_url"
                label="GitHub"
                value="{{ $user->github_url ?? old('github_url') }}"
            />
            <x-form.input
                type="text"
                name="twitter_url"
                label="𝕏 (Twitter)"
                value="{{ $user->twitter_url ?? old('twitter_url') }}"
            />

            <div class="text-right">
                <x-form.button type="submit">Save</x-form.button>
            </div>
        </div>
    </div>
</x-form.wrapper>
