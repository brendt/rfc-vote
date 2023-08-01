<div>
    @php
        $vote = $user?->getVoteForRfc($rfc);
    @endphp

    @if($vote)
        <form
            action="{{ action(\App\Http\Controllers\StoreArgumentController::class, $rfc) }}"
            method="post"
        >
            @csrf

            <div class="">
                <div class="grid grid-cols-1 gap-2">
                    <p>
                        Add your argument
                    </p>

                    <div class="grid gap-2">
                        <textarea name="body"></textarea>
                        @error('body')
                        {{ $message }}
                        @enderror
                    </div>

                    <button type="submit">Submit</button>
                </div>
            </div>
        </form>
    @endif()
</div>
