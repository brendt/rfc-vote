@php
    $styles = 'flex gap-2 items-center relative focus:outline-none focus:shadow-outline text-font';
@endphp

<div {{dusk('dark-mode-button')}} class="flex justify-center items-center mt-7 md:mt-0">
    <button
        id="header__moon"
        title="Switch to light mode"
        class="{{ $styles }}"
        x-cloak
        @click="toggle()"
        x-bind:class="{ 'hidden': !darkMode }"
    >
        <x-icons.dark-mode />

        <span class="md:hidden">Switch to Light mode</span>
    </button>

    <button
        id="header__indeterminate"
        title="Switch to dark mode"
        class="{{ $styles }}"
        x-cloak
        @click="toggle()"
        x-bind:class="{ 'hidden': darkMode }"
    >
        <x-icons.light-mode/>

        <span class="md:hidden">Switch to Dark mode</span>
    </button>
</div>
