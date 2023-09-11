@component('layouts.base')
    <div class="grid mx-auto container max-w-[800px] px-4 gap-6 my-4 md:my-12">
        <x-profile.settings.profile :user="$user" />
        <x-profile.settings.email :user="$user" />
        <x-profile.settings.password :user="$user" />
        <x-profile.settings.verification :user="$user" />
    </div>
@endcomponent
