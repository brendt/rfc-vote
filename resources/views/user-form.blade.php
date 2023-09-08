@component('layouts.base')
    <div class="mx-auto container max-w-[800px] px-4 gap-6 md:gap-12 mt-4 md:mt-12 mb-8 text-font">
        <x-form class="grid grid-cols-2 gap-2 bg-form p-4 border-gray-300 dark:border-gray-700 border shadow-md rounded-lg"
                action="{{ $action }}"
                method="post"
        >
            @bind($user)
            <x-form-input name="name"  label="Name" class="bg-input" type="text"/>
            <x-form-input name="username" label="Username" class="bg-input" type="text"/>
            <x-form-input name="email"  label="Email" class="bg-input" type="email"/>
            <x-form-input name="website_url"  label="Website URL" class="bg-input"
                          type="text"/>
            <x-form-input name="github_url" label="GitHub URL" class="bg-input" type="text"/>
            <x-form-input name="twitter_url"  label="Twitter URL" class="bg-input"
                          type="text"/>
            <x-form-input name="reputation"  label="Reputation" class="bg-input" type="number"/>

            @php
                $options = [];
                foreach (\App\Models\UserFlair::cases() as $flair){
                    $options[$flair->value] = ucfirst($flair->value);
                }
            @endphp
            <x-form-select name="flair" label="User Flair" :options="$options" placeholder="Choose..." :default="$user->flair?->value" />

            <x-form-checkbox name="is_admin"  label="Is Admin"/>

            <div class="flex justify-end items-baseline gap-2 col-span-2">
                <x-form-submit>
                    <span>Save</span>
                </x-form-submit>
                <a href="/admin/users">Back</a>
            </div>
            @endbind
        </x-form>
    </div>

@endcomponent
