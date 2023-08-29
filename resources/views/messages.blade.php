@component('layouts.base')
    <div class="grid mx-auto container max-w-[800px] px-4 gap-6 my-4 md:my-12">
        <livewire:message-list :user="$user"/>
    </div>
@endcomponent
