<button
    type="button"
    class="md:hidden w-8 h-8 flex flex-col justify-center items-center gap-1.5 relative z-20"
    aria-hidden="true"
    aria-label="Open mobile menu"
    @click="open = !open"
>
    <i
        class="w-7 h-[3px] rounded-full bg-white transition-transform duration-300"
        :style="open ? 'transform: rotate(-45deg) translateX(-6px)' : ''"
    ></i>
    <i
        class="w-7 h-[3px] rounded-full bg-white transition-transform duration-300"
        :style="open ? 'transform: rotate(45deg) translateX(-6px)' : ''"
    ></i>
</button>
