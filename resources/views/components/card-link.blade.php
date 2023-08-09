<a href="{{ $href }}" class="flex rounded">
    <x-card {{ $attributes->merge(['class' => 'border-4 border-transparent hover:bg-gray-50 hover:border-purple-400']) }}>{{ $slot }}</x-card>
</a>
