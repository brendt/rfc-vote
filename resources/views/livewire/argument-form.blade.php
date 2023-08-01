<div>
    @if($vote && !$existingArgument)
        <div class="flex {{ $vote->type->getJustify() }}">
            <div class="
                    flex-1
                    border-2
                    border-{{ $vote->type->getColor() }}-400
                    p-4 max-w-4xl flex gap-4
                    items-end
                    {{ $vote->type->getJustify() }}
            ">
                <div class="w-full">
                    <small>
                        {{ $user->name }}
                    </small>

                    <div class="grid gap-2">
                        <textarea name="body" wire:model="body"
                                  class="w-full border border-gray-300"></textarea>

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
                        text-{{ $vote->type->getColor() }}-800
                        text-center
                    "
                    wire:click="storeArgument"
                >Submit
                </button>
            </div>
        </div>
    @endif()
</div>
