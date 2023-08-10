<button {{ $attributes->except(['class']) }}>
    <x-tag {{ $attributes->only(['class']) }}>{{ $slot }}</x-tag>
</button>
