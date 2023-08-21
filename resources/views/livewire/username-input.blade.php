<x-form.input
    :name="$name"
    :label="$label"
    wire:model="value"
    :placeholder="$placeholder"
    :message="$message"
    required=""
>
    @error('value') <span class="text-sm text-red-600 leading-4 block mt-1 ml-1" role="alert">{{ $message }}</span> @enderror
</x-form.input>
