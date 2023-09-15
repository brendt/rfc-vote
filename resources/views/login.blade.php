@component('layouts.base')

    <div class="mx-auto max-w-[500px] my-4 md:my-12 text-font">
        <x-form.wrapper
            heading="Login to your account"
            method="{{ route('login') }}"
            method="post"
        >
            <div class="space-y-3">
                <x-form.input
                    label="Email"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autocomplete="username"
                    placeholder="Enter your email address"
                    autofocus
                />

                <x-form.input
                    label="Password"
                    type="password"
                    name="password"
                    autocomplete="current-password"
                    placeholder="Enter your password"
                    required
                />
            </div>

            <div class="mt-6 justify-between flex items-baseline flex-wrap">
                <a
                    {{dusk('reset-password-link')}}
                    href="{{ action(App\Http\Controllers\ForgotPasswordController::class) }}"
                    class="text-font underline opacity-80 hover:opacity-100"
                >
                    Forget Password?
                </a>

                <div class="inline-flex gap-4">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" />
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>


                    <x-form.button type="submit" class="!m-0">
                        <x-icons.login class="h-6 w-6" />
                        Login
                    </x-form.button>
                </div>
            </div>
        </x-form.wrapper>

        <div class="flex items-center gap-3 mt-8 justify-center">
            <a
                {{dusk('register-link')}}
                href="{{ action(App\Http\Controllers\RegisterController::class) }}"
                class="underline hover:no-underline"
            >
                Register
            </a>

            <span>or</span>

            <x-buttons.main
                href="{{ action(App\Http\Controllers\SocialiteRedirectController::class, 'github') }}"
                class="!bg-gray-800 hover:!bg-gray-700"
            >
                <x-icons.github class="h-6 w-6 fill-white" />
                Log in with GitHub
            </x-buttons.main>
        </div>
    </div>

@endcomponent
