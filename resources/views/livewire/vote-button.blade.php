<div>
    <button
        class="
            font-mono
            bg-blue-100
            border-4
            border-blue-400
            p-4
            px-8
            text-lg
            text-blue-500
            hover:bg-blue-400
            hover:text-white
        "
        wire:click="showModal()"
    >
        @if($user?->hasArgumentFor($vote))
            Edit your vote
        @else
            Vote
        @endif
    </button>

    @if($this->showModal)
        <div class="fixed top-0 left-0 w-full flex justify-center">
            <div class="bg-blue-200 lg:w-1/4 p-4 grid gap-4 shadow-xl border-4 border-blue-400 mt-8">
                <p>
                    What's your vote for {{ $vote->title }}? You can change your vote and argument afterwards.
                </p>
                <div class="grid grid-cols-12 gap-4">
                    <textarea wire:model="body" class="
                        col-span-12
                        font-mono
                        border-4
                        border-blue-400
                    "></textarea>

                    <button
                        class="
                            col-span-6
                            font-mono
                            border-4
                            p-4
                            px-8
                            text-lg
                            text-green-500

                            @if($this->getArgument()->type === \App\Models\VoteType::YES)
                                bg-green-400
                                border-green-400
                                text-white
                            @else
                                bg-green-100
                                border-green-400
                                hover:bg-green-400
                                hover:text-white
                            @endif
                        "
                        wire:click="submitYes()"
                    >
                        Yes
                    </button>

                    <button
                        class="
                            col-span-6
                            font-mono
                            border-4
                            p-4
                            px-8
                            text-lg
                            text-red-500

                            @if($this->getArgument()->type === \App\Models\VoteType::NO)
                                bg-red-400
                                border-red-400
                                text-white
                            @else
                                bg-red-100
                                border-red-400
                                hover:bg-red-400
                                hover:text-white
                            @endif
                        "
                        wire:click="submitNo()"
                    >
                        No
                    </button>

                    <div class="col-span-12 flex justify-end">
                        <button wire:click="closeModal" class="underline hover:no-underline">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
