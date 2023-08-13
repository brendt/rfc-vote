<button {{ $attributes->merge(['class' => 'px-5 py-1 text-[.9rem] rounded-full font-bold text-gray-900 transition-colors border']) }}>
    <span class="flex items-center gap-2">
        <x-dynamic-component :component="$icon" class="w-4 h-4" /> {{ $slot }}
    </span>
</button>
