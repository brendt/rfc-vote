@component('layouts.base')

    <div class="mx-auto container max-w-[800px] px-4 gap-6 md:gap-12 mt-4 md:mt-12 mb-8">
        <x-form class="grid grid-cols-2 gap-2 bg-white p-4 shadow-lg border-gray-300 border"
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

            <div>
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex justify-between items-baseline gap-2 col-span-2">
                <a href="{{ action(\App\Http\Controllers\SocialiteRedirectController::class, 'github') }}" class="p-2 px-4 bg-black rounded text-white font-bold hover:bg-gray-200 hover:text-black">
                    {{ __('Log in with GitHub') }}
                </a>

                <x-form-submit>
                    Login
                </x-form-submit>
            </div>
        </x-form>
    </div>

@endcomponent
