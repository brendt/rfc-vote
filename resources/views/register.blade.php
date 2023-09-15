@component('layouts.base')

    <div class="mx-auto max-w-[500px] my-4 md:my-12 text-font">
        <x-form.wrapper
            method="{{ route('register') }}"
            method="post"
            heading="Register your account"
        >
            <div class="space-y-3">
                <x-form.input
                    name="name"
                    label="Name"
                    :value="old('name')"
                    placeholder="Enter your name"
                    required
                />

                <x-form.input
                    name="email"
                    label="Email"
                    :value="old('email')"
                    placeholder="Enter your email address"
                    required
                />

                <livewire:username-input
                    name="username"
                    label="Username"
                    :value="old('username')"
                    placeholder="Enter your username"
                    required="true"
                />

                <x-form.input
                    type="password"
                    name="password"
                    label="Password"
                    placeholder="Enter your password"
                    required
                />

                <x-form.input
                    type="password"
                    name="password_confirmation"
                    label="Confirm your password"
                    placeholder="Confirm your password"
                    required
                />
            </div>

            <div class="text-right mt-6">
                <x-form.button type="submit">
                    <x-icons.register class="h-6 w-6"/>
                    Register
                </x-form.button>
            </div>
        </x-form.wrapper>


        <div class="flex items-center gap-3 mt-8 justify-center">
            <a
                href="{{ action(App\Http\Controllers\LoginController::class) }}"
                class="underline hover:no-underline"
            >
                Login
            </a>

            <span>or</span>

            <x-buttons.github />
        </div>
    </div>

@endcomponent
