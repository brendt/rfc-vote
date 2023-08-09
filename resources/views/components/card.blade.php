<div
    {{ $attributes->merge([
        'class' => "
            border-gray-200 border
            bg-white
            rounded
            shadow-md
            flex flex-col justify-between gap-2
            p-4 md:pt-8 md:px-6
            "
    ]) }}>

    {{ $slot }}
</div>
