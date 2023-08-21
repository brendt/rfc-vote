<div>
    @foreach($pendingRequests as $request)
        <div class="p-4 bg-white flex justify-between items-center">
            <div>
                {{ $request->user->name }}
            </div>

            <div>
                {{ $request->motivation }}
            </div>

            <div class="flex gap-2">
                <button class="p-4 py-2 bg-gray-100 hover:bg-gray-200" wire:click="accept({{ $request->id }})">Accept</button>
                <button class="p-4 py-2 bg-gray-100 hover:bg-gray-200" wire:click="deny({{ $request->id }})">{{ $isDenying?->is($request) ? 'Confirm' : 'Deny' }}</button>
            </div>
        </div>
    @endforeach

    @if($isAccepting)
        <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center">
            <div class="w-2/5 bg-red-100 p-4 grid gap-2 grid-cols-2">
                <p class="col-span-2">Accepting {{ $isAccepting->user->name }}'s verification request</p>

                <x-form.input wire:model="flair" name="flair" label="Flair Text"></x-form.input>
                <x-form.input wire:model="flairColor" name="flairColor" label="Flair Color"></x-form.input>

                <div class="flex justify-end col-span-2">
                    <x-form.button wire:click="accept({{ $isAccepting->id }})">Accept</x-form.button>
                </div>
            </div>

        </div>
    @endif
</div>
