@component('layouts.base')
    <div class="max-w-lg m-auto mt-12">
        <x-form.wrapper
            method="POST"
            action="{{ route('password.update') }}"
            :heading="__('Reset Password')"
        >
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="space-y-4">
                <x-form.input
                    :label="__('Email')"
                    type="email"
                    name="email"
                    :value="old('email', $request->email)"
                    :placeholder="__('Enter your email')"
                    required autofocus autocomplete="username"
                />

                <x-form.input
                    :label="__('New password')"
                    type="password"
                    name="password"
                    :placeholder="__('Enter your new password')"
                    required
                    autocomplete="new-password"
                />

                <x-form.input
                    :label="__('Confirm new password')"
                    type="password"
                    name="password_confirmation"
                    :placeholder="__('Confirm your new password')"
                    required
                    autocomplete="new-password"
                />

                <div class="text-right mt-7">
                    <x-form.button type="submit">
                        <x-icons.arrow-path class="w-5 h-5" />
                        {{ __('Reset Password') }}
                    </x-form.button>
                </div>
            </div>
        </x-form.wrapper>
    </div>
@endcomponent
