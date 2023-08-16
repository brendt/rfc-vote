@component('layouts.base')

    <div class="mx-auto max-w-[500px] mt-4 md:mt-12">
        <x-form.wrapper
            method="{{ route('register') }}"
            method="post"
            :heading="__('Register your account')"
        >
            <div class="space-y-3">
                <x-form.input
                    name="name"
                    :label="__('Name')"
                    :value="old('name')"
                    :placeholder="__('Enter your name')"
                    required
                />

                <x-form.input
                    name="username"
                    :label="__('Username')"
                    :value="old('username')"
                    :placeholder="__('Enter your username')"
                    required
                />

                <x-form.input
                    name="email"
                    :label="__('Email')"
                    :value="old('email')"
                    :placeholder="__('Enter your email address')"
                    required
                />

                <x-form.input
                    type="password"
                    name="password"
                    :label="__('Password')"
                    :placeholder="__('Enter your password')"
                    required
                />

                <x-form.input
                    type="password"
                    name="password_confirmation"
                    :label="__('Confirm your password')"
                    :placeholder="__('Confirm your password')"
                    required
                />
            </div>

            <div class="text-right mt-6">
                <x-form.button type="submit">
                    <x-icons.register class="h-6 w-6" />
                    {{ __('Register') }}
                </x-form.button>
            </div>
        </x-form.wrapper>

        <hr>

        <div class="flex items-center gap-3 mt-8 justify-center">
            <a
                href="{{ action(App\Http\Controllers\LoginController::class) }}"
                class="underline hover:no-underline"
            >
                Login
            </a>

            <span>or</span>

            <x-buttons.main
                href="{{ action(App\Http\Controllers\SocialiteRedirectController::class, 'github') }}"
                class="!bg-gray-900 hover:!bg-gray-700"
            >
                <x-icons.github class="h-6 w-6 fill-white" />
                {{ __('Log in with GitHub') }}
            </x-buttons.main>
        </div>
    </div>

@endcomponent
