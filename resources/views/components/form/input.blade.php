@php
    /**
     * @var string $slot
     * @var string|null $label
     * @var Illuminate\View\ComponentAttributeBag $attributes
     */
@endphp

<div>
    <label>
        @isset($label)
            <b class="text-sm">{{ $label }}</b>
        @endisset

        <input
            {{ $attributes->merge([
                'class' => 'border text-font bg-input border-divider rounded-md px-3 py-2 w-full ring-1 focus:ring-2 ring-transparent focus:border-purple-300 focus:ring-purple-500/50 focus:outline-none',
            ]) }}
        />
    </label>

    @error($attributes->get('name'))
        @isset($message)
            <span class="text-sm text-red-600 leading-4 block mt-1 ml-1" role="alert">
                {{ $message }}
            </span>
        @endisset
    @enderror

    {{$slot}}
</div>
