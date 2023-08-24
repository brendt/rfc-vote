@component('layouts.base')

    <div class="mx-auto max-w-[500px] my-4 md:my-12 dark:text-white">
        <x-form.wrapper
            :heading="__('Login to your account')"
            method="{{ route('login') }}"
            method="post"
        >
            <div class="space-y-3">
                <x-form.input
                    :label="__('Email')"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autocomplete="username"
                    :placeholder="__('Enter your email address')"
                    autofocus
                />

                <x-form.input
                    :label="__('Password')"
                    type="password"
                    name="password"
                    autocomplete="current-password"
                    :placeholder="__('Enter your password')"
                    required
                />
            </div>

            <div class="mt-6 justify-between flex items-baseline flex-wrap">
                <a
                    href="{{ action(App\Http\Controllers\ForgotPasswordController::class) }}"
                   class="text-purple-900 hover:underline"
                >
                    {{ __('Forget Password?') }}
                </a>

                <div class="inline-flex gap-4">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" class="checked:text-main"/>
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>

                    <x-form.button type="submit" class="!m-0">
                        <x-icons.login class="h-6 w-6" />
                        {{ __('Login') }}
                    </x-form.button>
                </div>
            </div>
        </x-form.wrapper>

        <div class="flex items-center gap-3 mt-8 justify-center">
            <a
                href="{{ action(App\Http\Controllers\RegisterController::class) }}"
                class="underline hover:no-underline"
            >
                Register
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
