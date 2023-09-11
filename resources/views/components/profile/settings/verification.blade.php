<x-form.wrapper
    action="{{ action([App\Http\Controllers\ProfileController::class, 'requestVerification']) }}"
    method="post"
    heading="Verification"
>
    @if($user->flair)
        <div class="flex gap-2 items-baseline">
            <p class="text-green-600 font-bold">Your current badge:</p>
            <x-profile.flair :user="$user"/>
        </div>
    @elseif($user->pendingVerificationRequests->isEmpty())
        <p class="mb-2 text-font">
            Please let us know if you're a PHP internal developer or an RFC Vote contributor by filling in this form. Verified users will get a badge before their username.
        </p>

        <p class="mb-4 text-font">
            If you're not an internal developer or RFC Vote contributor, but would still like a badge, you can also fill in the form to explain why: we might add other types of badges in the future.
        </p>

        <div class="space-y-3">
            <x-form.textarea name="motivation" label="Motivation" rows="5"></x-form.textarea>

            <div class="text-right">
                <x-form.button type="submit">
                    {{ "Request Verification" }}
                </x-form.button>
            </div>
        </div>
    @else
        <p class="text-green-600 font-bold">Your verification request is pending.</p>
    @endif
</x-form.wrapper>