<button {{ $attributes->merge(['class' => 'px-2 py-1 rounded-full font-bold text-gray-900 uppercase transition-colors']) }}>
    {{ $slot }}
</button>
