<x-tag class="{{ $voteType->class(yes: 'bg-teal-700', no: 'bg-pink-700') }} text-white font-bold">
    {{ $count }}
    {{ $voteType->value }}
</x-tag>
