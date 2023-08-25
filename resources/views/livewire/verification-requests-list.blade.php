
<div class="container mx-auto">
    <div class="grid gap-4 px-4">
        <div class="grid divide-y divide-gray-300">
            @foreach($pendingRequests as $request)
                <div class="grid grid-cols-6 lg:grid-cols-12 p-4 gap-4 items-center">
                    <div class="col-span-6 lg:col-span-2 space-y-1">
                        {{ $request->user->name }}
                    </div>

                    <div class="col-span-6">
                        {{ $request->motivation }}
                    </div>

                    <div class="col-span-6 md:col-span-4 flex gap-3 items-center justify-end text-sm">
                        <x-buttons.main-small-solid wire:click="accept({{ $request->id }})">
                             <span wire:loading.remove wire:target="accept({{ $request->id }})">
                                <x-icons.check class="w-4 h-4" />
                             </span>
                            <span wire:loading wire:target="accept({{ $request->id }})">
                             <x-icons.loading  class="w-4 h-4"></x-icons.loading>
                            </span>
                            Accept
                        </x-buttons.main-small-solid>

                        <x-buttons.main-small-solid wire:click="deny({{ $request->id }})">
                             <span wire:loading.remove wire:target="deny({{ $request->id }})">
                                <x-icons.trash class="w-4 h-4" />
                             </span>
                            <span wire:loading wire:target="deny({{ $request->id }})">
                             <x-icons.loading  class="w-4 h-4"></x-icons.loading>
                            </span>
                            {{ $isDenying?->is($request) ? 'Confirm' : 'Deny' }}
                        </x-buttons.main-small-solid>
                    </div>
                </div>
            @endforeach

            @if($isAccepting)
                <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center">
                    <div class="lg:w-2/5 bg-purple-100 p-4 grid gap-2 grid-cols-2">
                        <p class="col-span-2">Accepting {{ $isAccepting->user->name }}'s verification request</p>

                        <label for="flair" class="flex gap-2 items-center">
                            <b>Flair</b>

                            <select name="flair" id="flair" wire:model="flair" class="flex-grow">
                                @foreach(\App\Models\Enums\UserFlair::cases() as $userFlair)
                                    <option value="{{ $userFlair->value }}">{{ $userFlair->name }}</option>
                                @endforeach
                            </select>
                        </label>

                        <div class="flex justify-end col-span-2 gap-2">
                            <x-buttons.main wire:click="accept({{ $isAccepting->id }})">
                                <span wire:loading  wire:target="accept({{ $isAccepting->id }})">
                                    <x-icons.loading  class="w-4 h-4"></x-icons.loading>
                                </span>
                                Accept
                            </x-buttons.main>
                            <x-buttons.ghost wire:click="cancelAccept()">
                                <span wire:loading wire:target="cancelAccept">
                                    <x-icons.loading  class="w-4 h-4"></x-icons.loading>
                                </span>
                                Cancel
                            </x-buttons.ghost>
                        </div>
                    </div>

                </div>
            @endif
        </div>
    </div>
</div>
