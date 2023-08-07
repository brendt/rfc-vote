<div>
    @if($vote)
        <div class="flex {{ $vote->type->getJustify() }}">
            <div class="
                    flex-1
                    p-4 flex gap-4
                    items-end
                    {{ $vote->type->getJustify() }}
                    bg-white
                border-gray-200
                @if ($vote->type === \App\Models\VoteType::YES)
                    border-l-green-400
                    border-l-8
                    md:mr-8
                @else
                    border-r-red-400
                    border-r-8
                    md:ml-8
                @endif
                shadow-md
                p-4 gap-4 items-center
            ">
                <div class="w-full">
                    <small>
                        Your argument:
                    </small>

                    <div class="grid gap-2">
                        <textarea name="body" wire:model="body"
                                  rows="{{ $rowCount }}"
                                  class="
                                    w-full border border-{{ $vote->type->getColor() }}-200
                                    active:border-{{ $vote->type->getColor() }}-400
                                    rounded
                                   "
                        ></textarea>

                        @error('body')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                <button
                    type="submit"
                    class="
                        py-2 px-4 cursor-pointer
                        bg-{{ $vote->type->getColor() }}-200
                        hover:bg-{{ $vote->type->getColor() }}-400
                        hover:text-white
                        text-{{ $vote->type->getColor() }}-800
                        text-center
                        rounded
                        border-{{ $vote->type->getColor() }}-400
                        border
                    "
                    wire:click="storeArgument"
                >{{ $existingArgument ? 'Save' : 'Submit' }}
                </button>
            </div>
        </div>
    @endif()
</div>
