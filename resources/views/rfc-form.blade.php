@component('layouts.base')
    <div class="mx-auto container max-w-[800px] px-4 gap-6 md:gap-12 mt-4 md:mt-12 mb-8">
        <x-form class="grid grid-cols-2 gap-2 bg-white p-4 shadow-lg border-gray-300 border" action="{{ $action }}" method="post">
            @bind($rfc)
            <div class="col-span-2">
                <x-form-input name="title" label="Title"/>
            </div>
            <x-form-input type="date" name="published_at" label="Published at"/>
            <x-form-input type="date" name="ends_at" label="Ends at"/>
            <div class="col-span-2">
                <x-form-textarea rows="2" name="teaser" label="Teaser"/>
            </div>
            <div class="col-span-2">
                <x-form-textarea rows="4" name="description" label="Description"/>
            </div>
            <div class="col-span-2">
                <x-form-input name="url" label="URL"/>
            </div>

            <div class="flex justify-end items-baseline gap-2 col-span-2">
                <x-form-submit>
                    Save
                </x-form-submit>
                <a href="{{ request()->get('back', action(\App\Http\Controllers\RfcAdminController::class)) }}">Back</a>
            </div>
            @endbind()
        </x-form>
    </div>
@endcomponent
