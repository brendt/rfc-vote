@component('layouts.base')
    <div class="max-w-lg m-auto my-12">
        <x-form.wrapper
            method="POST"
            action="{{ route('password.update') }}"
            heading="Reset Password"
        >
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="space-y-4">
                <x-form.input
                    label="Email"
                    type="email"
                    name="email"
                    :value="old('email', $request->email)"
                    placeholder="Enter your email"
                    required autofocus autocomplete="username"
                />

                <x-form.input
                    label="New password"
                    type="password"
                    name="password"
                    placeholder="Enter your new password"
                    required
                    autocomplete="new-password"
                />

                <x-form.input
                    label="Confirm new password"
                    type="password"
                    name="password_confirmation"
                    placeholder="Confirm your new password"
                    required
                    autocomplete="new-password"
                />

                <div class="text-right mt-7">
                    <x-form.button type="submit">
                        <x-icons.arrow-path class="w-5 h-5" />
                        Reset Password
                    </x-form.button>
                </div>
            </div>
        </x-form.wrapper>
    </div>
@endcomponent
