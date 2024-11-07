@php
    $styles = 'flex gap-2 items-center relative focus:outline-none focus:shadow-outline text-font';
@endphp

<div {{dusk('dark-mode-button')}} class="flex justify-center items-center mt-7 md:mt-0">
    {{-- Dark theme switches to light theme --}}
    <button
        data-tippy-content="Dark theme"
        class="{{ $styles }}"
        @click="toggle('light')"
        x-show="switchType === 'dark'"
    >
        <x-icons.moon class="w-6 h-6 md:text-white" />

        <span class="md:hidden">Dark theme</span>
    </button>

    {{-- Light theme switches to system theme --}}
    <button
        data-tippy-content="Light theme"
        class="{{ $styles }}"
        @click="toggle('system')"
        x-show="switchType === 'light'"
    >
        <x-icons.sun class="w-6 h-6 md:text-white" />

        <span class="md:hidden">Light theme</span>
    </button>

    {{-- System theme switches to dark theme --}}
    <button
        data-tippy-content="System theme"
        class="{{ $styles }}"
        @click="toggle('dark')"
        x-show="switchType === 'system'"
    >
        <x-icons.computer-desktop class="w-6 h-6 md:text-white" />

        <span class="md:hidden">System theme</span>
    </button>
</div>
