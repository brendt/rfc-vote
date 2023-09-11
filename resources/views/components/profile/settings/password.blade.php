<x-form.wrapper
    action="{{ action([App\Http\Controllers\ProfileController::class, 'updatePassword']) }}"
    method="post"
    heading="Password"
>
    <p class="mb-4 text-font">
        @if ($user->password)
            You're logged in with a password, so you can change your password here.
        @else
            You're logged in with GitHub, so you haven't set a password yet. You can choose a password if you'd like to be able to use the password login as well.
        @endif
    </p>

    <div class="space-y-3">
        @if ($user->password)
            <x-form.input type="password" name="current_password" label="Current password" />
            <x-form.input type="password" name="new_password" label="New password" />
            <x-form.input type="password" name="new_password_confirmation" label="Confirm your new password" />
        @else
            <x-form.input type="password" name="password" label="Choose a password" />
            <x-form.input type="password" name="password_confirmation" label="Confirm your password" />
        @endif

        <div class="text-right">
            <x-form.button type="submit">
                {{ @$user->password ? "Change your password" : "Set your password" }}
            </x-form.button>
        </div>
    </div>
</x-form.wrapper>
