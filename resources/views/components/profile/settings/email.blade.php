<x-form.wrapper
    action="{{ action([App\Http\Controllers\ProfileController::class, 'updateEmail']) }}"
    method="post"
    heading="Email"
>
    <div class="col-span-2">
        <x-form.input
            type="email"
            name="email"
            label="Your Email Address"
            value="{{ $user->email ?? old('email') }}"
        />
    </div>

    <p class="text-red-600 leading-5 font-bold mt-2 tracking-wide">
        Note: you will need to confirm your new email address. Also: if you logged in with GitHub and change your email address, your GitHub login won't work anymore.
    </p>

    <div class="col-span-2 flex items-center gap-2 mt-4 font-bold">
        <input type="checkbox" value="1" id="email_optin" name="email_optin" {{ $user->email_optin ? 'checked' : '' }}>

        <label for="email_optin">Receive an email with RFC updates</label>
    </div>

    <div class="text-right mt-4">
        <x-form.button type="submit">Save email preferences</x-form.button>
    </div>
</x-form.wrapper>