@component('layouts.base')
    <div class="grid mx-auto container max-w-[800px] px-4 gap-6 mt-4 md:mt-12 mb-8">
        <x-form class="bg-white p-4 shadow-lg border-gray-300 border grid gap-2 grid-cols-2"
                action="{{ action([\App\Http\Controllers\ProfileController::class, 'update']) }}"
                method="post"
                enctype="multipart/form-data"
        >

            <h1 class="text-2xl font-bold col-span-2">Profile</h1>

            @bind($user)

            <div class="col-span-2">
                <x-form-input type="text" name="name" label="Name" />
            </div>

            <div class="col-span-2">
                <x-form-input type="text" name="email" label="Email" />
            </div>

            <div class="flex col-span-2 gap-4 items-center mt-4">
                @if($user->getAvatarUrl())
                    <img src="{{ $user->getAvatarUrl() }}" class="border-4 border-purple-800 shadow-xl rounded-full max-w-[100px]"/>
                @endif

                <x-form-input type="file" name="avatar" label="Choose a new avatar" />
            </div>

            <div class="col-span-2 mt-6">
                <h2 class="text-xl font-bold">Social links</h2>
                <x-form-input type="text" name="website_url" label="Website" />
                <x-form-input type="text" name="github_url" label="GitHub" />
                <x-form-input type="text" name="twitter_url" label="Twitter" />
            </div>

            <div class="flex justify-end items-baseline gap-2 col-span-2">
                <x-form-submit>
                    Save
                </x-form-submit>
            </div>
            @endbind()
        </x-form>

        <x-form class="bg-white p-4 shadow-lg border-gray-300 border"
                action="{{ action([\App\Http\Controllers\ProfileController::class, 'updatePassword']) }}"
                method="post">

            <h2 class="text-xl font-bold mt-2">Password</h2>

            @bind($user)

            @if($user->password)
                <p class="mt-2">You can change your password here if you need to.</p>
                <x-form-input type="password" name="current_password" label="Current password" />
                <x-form-input type="password" name="new_password" label="New password" />
                <x-form-input type="password" name="new_password_confirmation" label="Confirm your new password" />
            @else
                <p class="mt-2">You're logged in with Github, so you haven't set a password yet. You can choose a password if you'd like to be able to use the password login as well.</p>
                <x-form-input type="password" name="password" label="Choose a password" />
                <x-form-input type="password" name="password_confirmation" label="Confirm your password" />
            @endif

            <div class="flex justify-end items-baseline gap-2 col-span-2">
                <x-form-submit>
                    Save
                </x-form-submit>
            </div>
            @endbind()
        </x-form>
    </div>
@endcomponent
