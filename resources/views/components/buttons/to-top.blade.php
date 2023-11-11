<div
    class="sticky flex self-end justify-end bottom-0 pb-3 right-6 z-20"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY; updateVisibility() })"
    x-data="{ isVisible: false, scrolled: 0, updateVisibility() { this.isVisible = (this.scrolled / (document.documentElement.scrollHeight - window.innerHeight)) >= 0.5; } }"
    x-show="isVisible"
>
    <button
        x-show="isVisible"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-2"
        @click="window.scrollTo({top: 0});"
        class="rounded-full bg-purple-600 p-4 text-white shadow-md hover:bg-purple-700 duration-700 hover:-translate-y-3 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg active:bg-purple-800 active:shadow-lg"
    >
        <x-icons.arrow-double-up />
    </button>
</div>