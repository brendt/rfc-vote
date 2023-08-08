@component('layouts.base')

    <div class="mx-auto container max-w-[800px] px-4 gap-6 md:gap-12 mt-4 md:mt-12 mb-8 bg-white p-4 shadow-lg border-gray-300 border">
        <x-form class="grid grid-cols-2 gap-4 p-4"
                method="{{ route('login') }}"
                method="post">

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div>
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class=" justify-between flex  items-baseline col-span-2">
                <a href="{{ action(\App\Http\Controllers\ForgotPassword::class) }}" class="text-black underline hover:no-underline">Forget Password?</a>
                <div class="flex space-x-4">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember"/>
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>

                    <button type="submit"
                            class="p-2 px-4 bg-blue-400 rounded text-white font-bold hover:bg-blue-600 hover:text-white">
                        Login
                    </button>
                </div>
            </div>
        </x-form>

        <hr>

        <div class="flex items-baseline gap-2 p-4 mt-4 justify-center">
            <a href="{{ action(\App\Http\Controllers\RegisterController::class) }}" class="underline hover:no-underline">Register</a>
            <span>or</span>
            <a href="{{ action(\App\Http\Controllers\SocialiteRedirectController::class, 'github') }}" class="p-2 px-4 bg-black rounded text-white font-bold hover:bg-gray-200 hover:text-black">
                {{ __('Log in with GitHub') }}
            </a>
        </div>
    </div>

@endcomponent
