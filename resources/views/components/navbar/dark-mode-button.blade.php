<div class="flex items-center ml-4 mt-4 md:m-0 bg-">
    <button
        id="header__moon"
        title="Switch to light mode"
        class="relative focus:outline-none focus:shadow-outline text-font"
        x-cloak
        @click="toggle()"
        x-bind:class="{ 'hidden': !darkMode }"
    >
        <x-icons.dark-mode />
    </button>

    <button
        id="header__indeterminate"
        title="Switch to dark mode"
        class="relative focus:outline-none focus:shadow-outline text-font"
        x-cloak
        @click="toggle()"
        x-bind:class="{ 'hidden': darkMode }"
    >
        <x-icons.light-mode/>
    </button>
</div>