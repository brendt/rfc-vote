@component('layouts.base')

    <div class="mx-auto max-w-[500px] my-4 md:my-12">
        <x-form.wrapper
            method="POST"
            action="{{ route('verification.send') }}"
            heading="Verify Email Address"
        >
            <p class="mb-5 text-gray-500">
                Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.
            </p>

            @if (session('status') === 'verification-link-sent')
                <x-success-message>
                    A new verification link has been sent to the email address you provided in your profile settings.
                </x-success-message>
            @endif

            <div class="flex justify-end gap-2 items-center mt-7">
                <x-form.button type="submit">
                    <x-icons.envelope class="w-6 h-6" />
                    Resend Verification Email
                </x-form.button>

                <x-form.button
                    type="button"
                    class="!bg-transparent !text-gray-700 hover:!bg-gray-100"
                    onclick="document.getElementById('logout-form').submit()"
                >
                    Logout
                </x-form.button>
            </div>
        </x-form.wrapper>
    </div>

    <form method="POST" action="{{ route('logout') }}" class="hidden" id="logout-form">
        @csrf
    </form>

@endcomponent
