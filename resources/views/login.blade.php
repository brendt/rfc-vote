@component('layouts.base')

    <div class="mx-auto max-w-[500px] mt-4 md:mt-12">
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

            <div class="mt-6 justify-between flex items-baseline">
                <div class="inline-flex gap-4">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember"/>
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <a
                        href="{{ action(App\Http\Controllers\ForgotPasswordController::class) }}"
                        class="text-purple-900 hover:underline"
                >
                    {{ __('Forget Password?') }}
                </a>
            </div>
            <div class="w-full mt-6">
                <x-form.button type="submit" class="w-full flex justify-center">
                    <x-icons.login class="h-6 w-6"/>
                    {{ __('Login') }}
                </x-form.button>
            </div>
            <div class="flex items-center justify-center mt-3 space-x-4">
                <hr class="flex-grow border-t border-gray-300">
                <p class="font-medium">or</p>
                <hr class="flex-grow border-t border-gray-300">
            </div>


            <div class="w-full mt-3 flex justify-between align-items-center">
                <div>
                    <x-buttons.main
                            href="{{ action(App\Http\Controllers\SocialiteRedirectController::class, 'github') }}"
                            class="!bg-gray-900 hover:!bg-gray-700"
                    >
                        <x-icons.github class="h-6 w-6 fill-white"/>
                        {{ __('Log in with GitHub') }}
                    </x-buttons.main>
                </div>
                <div>
                    <x-buttons.main
                            href="{{ action(App\Http\Controllers\RegisterController::class) }}"
                            class="!bg-gray-900 hover:!bg-gray-700"
                    >
                        <x-icons.register class="h-6 w-6 fill-white"/>
                        {{ __('Register') }}
                    </x-buttons.main>
                </div>
            </div>
        </x-form.wrapper>
    </div>

@endcomponent
