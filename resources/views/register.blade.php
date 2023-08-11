@component('layouts.base')

    <div class="mx-auto container max-w-[800px] px-4 gap-6 md:gap-12 mt-4 md:mt-12 mb-8 bg-white p-4 shadow-lg border-gray-300 border">
        <x-form class="grid grid-cols-2 gap-4 p-4"
                method="{{ route('register') }}"
                method="post">

            <x-form-input name="name" label="Name" required />

            <x-form-input name="email" label="Email" required />

            <x-form-input type="password" name="password" label="Password" required />
            <x-form-input type="password" name="password_confirmation" label="Confirm your password" required />

            <div class="flex justify-end items-baseline gap-2 col-span-2">
                <button type="submit" class="p-2 px-4 bg-blue-400 rounded text-white font-bold hover:bg-blue-600 hover:text-white">Register</button>
            </div>
        </x-form>

        <hr>

        <div class="flex items-baseline gap-2 p-4 mt-4 justify-center">
            <a href="{{ action(\App\Http\Controllers\LoginController::class) }}" class="underline hover:no-underline">Login</a>
            <span>or</span>
            <a href="{{ action(\App\Http\Controllers\SocialiteRedirectController::class, 'github') }}" class="p-2 px-4 bg-black rounded text-white font-bold hover:bg-gray-200 hover:text-black">
                {{ __('Log in with GitHub') }}
            </a>
        </div>
    </div>

@endcomponent
