<div
    x-data="avatarSettings"
    class="flex flex-col md:flex-row gap-3  md:gap-5 items-center my-4"
>
    @if ($user->getAvatarUrl())
        <img
            :src="avatar"
            data-src="{{ $user->getAvatarUrl() }}"
            class="shadow-xl rounded-full aspect-square"
            width="80"
            height="80"
            alt="Your avatar"
        />
    @endif

    <div class="flex flex-col w-full relative py-1 md:my-3">
        <label
            class="flex flex-col text-gray-500 items-center gap-1 border-4 border-dashed w-full rounded-sm p-3 md:p-5 cursor-pointer border-divider bg-background opacity-70 hover:opacity-100 transition-opacity"
            x-bind="area"
        >
            <x-icons.camera class="w-10 h-10" />

            <div>
                <span
                    x-html="areaMessage"
                    class="dark:text-gray-600 tracking-wide pointer-events-none"
                ></span>

                <input
                    x-ref="fileInp"
                    @change="onFileChange"
                    type="file"
                    name="avatar"
                    class="hidden"
                />
            </div>
        </label>

        <small
            x-show="avatarChanged"
            class="flex gap-1 items-center absolute -bottom-5 right-1 text-orange-600"
        >
            <x-icons.information-circle class="w-4 h-4 inline-block" />
            Click save below to update your avatar
        </small>
    </div>
</div>