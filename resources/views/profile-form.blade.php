@component('layouts.base')
    <div class="grid mx-auto container max-w-[800px] px-4 gap-6 my-4 md:my-12">
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

        <x-form.wrapper
            action="{{ action([App\Http\Controllers\ProfileController::class, 'updateEmail']) }}"
            method="post"
            heading="Email"
        >
            <div class="col-span-2">
                <x-form.input
                    type="email"
                    name="email"
                    label="Your Email Address"
                    value="{{ $user->email ?? old('email') }}"
                />
            </div>

            <p class="text-red-600 leading-5 font-bold mt-2 tracking-wide">
                Note: you will need to confirm your new email address. Also: if you logged in with GitHub and change your email address, your GitHub login won't work anymore.
            </p>

            <div class="col-span-2 flex items-center gap-2 mt-4 font-bold">
                <input type="checkbox" value="1" id="email_optin" name="email_optin" {{ $user->email_optin ? 'checked' : '' }}>

                <label for="email_optin">Receive an email with RFC updates</label>
            </div>

            <div class="text-right mt-4">
                <x-form.button type="submit">Save email preferences</x-form.button>
            </div>
        </x-form.wrapper>

        <x-form.wrapper
            action="{{ action([App\Http\Controllers\ProfileController::class, 'updatePassword']) }}"
            method="post"
            heading="Password"
        >
            <p class="mb-4 text-font">
                @if ($user->password)
                    You're logged in with a password, so you can change your password here.
                @else
                    You're logged in with GitHub, so you haven't set a password yet. You can choose a password if you'd like to be able to use the password login as well.
                @endif
            </p>

            <div class="space-y-3">
                @if ($user->password)
                    <x-form.input type="password" name="current_password" label="Current password" />
                    <x-form.input type="password" name="new_password" label="New password" />
                    <x-form.input type="password" name="new_password_confirmation" label="Confirm your new password" />
                @else
                    <x-form.input type="password" name="password" label="Choose a password" />
                    <x-form.input type="password" name="password_confirmation" label="Confirm your password" />
                @endif

                <div class="text-right">
                    <x-form.button type="submit">
                        {{ @$user->password ? "Change your password" : "Set your password" }}
                    </x-form.button>
                </div>
            </div>
        </x-form.wrapper>

        <x-form.wrapper
            action="{{ action([App\Http\Controllers\ProfileController::class, 'requestVerification']) }}"
            method="post"
            heading="Verification"
        >
            <p class="mb-2 text-font">
                Please let us know if you're a PHP internal developer or an RFC Vote contributor by filling in this form. Verified users will get a badge before their username.
            </p>
            <p class="mb-4 text-font">
                If you're not an internal developer or RFC Vote contributor, but would still like a badge, you can also fill in the form to explain why: we might add other types of badges in the future.
            </p>

            @if($user->flair)
                <div class="flex gap-2 items-baseline">
                    <p class="text-green-600 font-bold">Your current badge:</p>

                    <x-profile.flair :user="$user"/>
                </div>
            @elseif($user->pendingVerificationRequests->isEmpty())
                <div class="space-y-3">
                    <x-form.textarea name="motivation" label="Motivation" rows="5"></x-form.textarea>

                    <div class="text-right">
                        <x-form.button type="submit">
                            {{ "Request Verification" }}
                        </x-form.button>
                    </div>
                </div>
            @else
                <p class="text-green-600 font-bold">Your verification request is pending.</p>
            @endif
        </x-form.wrapper>


    </div>
@endcomponent
