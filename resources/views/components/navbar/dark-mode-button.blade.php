@php
    $styles = 'flex gap-2 items-center relative focus:outline-none focus:shadow-outline text-font';
@endphp

<div {{dusk('dark-mode-button')}} class="flex justify-center items-center mt-7 md:mt-0">
    {{-- Dark theme switches to light theme --}}
    <button
        data-tippy-content="Switch to light theme"
        class="{{ $styles }}"
        @click="toggle('light')"
        x-show="darkMode === true"
    >
        <x-icons.moon class="w-6 h-6 md:text-white" />

        <span class="md:hidden">Switch to Light theme</span>
    </button>

    {{-- Light theme switches to system theme --}}
    <button
        data-tippy-content="Switch to system theme"
        class="{{ $styles }}"
        @click="toggle('system')"
        x-show="darkMode === false"
    >
        <x-icons.sun class="w-6 h-6 md:text-white" />

        <span class="md:hidden">Switch to System theme</span>
    </button>

    {{-- System theme switches to dark theme --}}
    <button
        data-tippy-content="Switch to dark theme"
        class="{{ $styles }}"
        @click="toggle('dark')"
        x-show="darkMode === null"
    >
        <x-icons.computer-desktop class="w-6 h-6 md:text-white" />

        <span class="md:hidden">Switch to Dark theme</span>
    </button>
</div>
