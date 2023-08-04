@component('layouts.base')

    <div class="mx-auto container max-w-[800px] px-4 gap-6 md:gap-12 mt-4 md:mt-12 mb-8">
        <x-form class="grid grid-cols-2 gap-2 bg-white p-4 shadow-lg border-gray-300 border"
                method="{{ action([\Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::class, 'destroy']) }}"
                method="post">

            <div class="flex justify-end items-baseline gap-2 col-span-2">
                <x-form-submit>
                    Logout
                </x-form-submit>
            </div>
        </x-form>
    </div>

@endcomponent
