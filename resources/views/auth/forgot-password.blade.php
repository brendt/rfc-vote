@component('layouts.base')
    <div class="max-w-lg m-auto my-12">
        <x-form.wrapper
            method="POST"
            action="{{ route('password.email') }}"
            heading="Forgot your password?"
        >
            <x-success-message>{{ session('status') }}</x-success-message>

            <p class="mb-5 text-gray-500">
                No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
            </p>

            <x-form.input
                label="Email"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                placeholder="Enter your email address"
                autocomplete="username"
            />

            <div class="text-right mt-7">
                <x-form.button type="submit">
                    <x-icons.envelope class="w-6 h-6" />
                    Email reset password link
                </x-form.button>
            </div>
        </x-form.wrapper>
    </div>
@endcomponent
