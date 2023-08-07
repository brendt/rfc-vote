@component('layouts.base')
    <div class="grid mx-auto container max-w-[800px] px-4 gap-6 mt-4 md:mt-12 mb-8">
        <x-form class="bg-white p-4 shadow-lg border-gray-300 border"
                action="{{ action([\App\Http\Controllers\ProfileController::class, 'update']) }}"
                method="post"
                enctype="multipart/form-data"
        >

            <h2 class="text-xl font-bold">Profile</h2>

            @bind($user)

            <x-form-input type="text" name="name" label="Name" />

            <div>
                <img src="{{ $user->getAvatarUrl() }}" />
                {{ $user->getAvatarUrl() }}
                <x-form-input type="file" name="avatar" label="Choose a new avatar" />
            </div>

            <div class="flex justify-end items-baseline gap-2 col-span-2">
                <x-form-submit>
                    Save
                </x-form-submit>
            </div>
            @endbind()
        </x-form>

        <x-form class="bg-white p-4 shadow-lg border-gray-300 border"
                action="{{ action([\App\Http\Controllers\ProfileController::class, 'updatePassword']) }}"
                method="post">

            <h2 class="text-xl font-bold">Password</h2>

            @bind($user)

            <x-form-input type="password" name="current_password" label="Current password" />
            <x-form-input type="password" name="new_password" label="New password" />
            <x-form-input type="password" name="new_password_confirmation" label="Confirm your new password" />

            <div class="flex justify-end items-baseline gap-2 col-span-2">
                <x-form-submit>
                    Save
                </x-form-submit>
            </div>
            @endbind()
        </x-form>
    </div>
@endcomponent
