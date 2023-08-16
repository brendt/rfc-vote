@component('layouts.base')
    <div class="max-w-lg m-auto mt-12">
        <x-form.wrapper
            method="POST"
            action="{{ route('password.email') }}"
            :heading="__('Reset password')"
        >
            @csrf

            <x-form.input
                :label="__('Email')"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                :placeholder="__('Enter your email address')"
                autocomplete="username"
            />

            <div class="text-right mt-7">
                <x-form.button type="submit">
                    <x-icons.envelope class="w-6 h-6" />
                    {{ __('Email reset password link') }}
                </x-form.button>
            </div>
        </x-form.wrapper>
    </div>
@endcomponent
