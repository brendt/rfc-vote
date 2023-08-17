<x-tag class="{{ $voteType->class(yes: 'bg-green-700', no: 'bg-red-700') }} text-white font-bold">
    {{ $count }}
    {{ $voteType->value }}
</x-tag>
