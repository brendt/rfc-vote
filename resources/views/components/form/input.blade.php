@php
    /**
     * @var string $slot
     * @var string $label
     * @var Illuminate\View\ComponentAttributeBag $attributes
     */
@endphp

<div>
    <label>
        <b class="text-sm text-gray-600">{{ $label }}</b>

        <input
            {{ $attributes->merge([
                'class' => 'border border-gray-300 rounded-md p-2 w-full ring-1 focus:ring-2 ring-transparent focus:border-purple-300 focus:ring-purple-500/50 focus:outline-none',
            ]) }}
        />
    </label>
</div>
