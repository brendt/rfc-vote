<div>
    @if($user && $user->getVoteForRfc($rfc))
        <p>
            Add your argument
        </p>

        <form
            action="{{ action(\App\Http\Controllers\StoreArgumentController::class, $rfc) }}"
            method="post"
        >
            @csrf

            <textarea name="body"></textarea>
            @error('body')
            @enderror

            <button type="submit">Submit</button>
        </form>
    @endif()
</div>
