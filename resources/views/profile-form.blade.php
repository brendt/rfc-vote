@component('layouts.base')
    <div class="grid grid-cols-1 lg:grid-cols-2 mx-auto container gap-6 my-4 md:my-10">
        <div class="space-y-6">
            <x-profile.settings.profile :user="$user" />
            <x-profile.settings.email :user="$user" />
        </div>
        <div class="space-y-6">
            <x-profile.settings.password :user="$user" />
            <x-profile.settings.verification :user="$user" />
        </div>
    </div>
@endcomponent
