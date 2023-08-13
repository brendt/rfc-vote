<x-tag class="{{ $voteType->class(yes: 'bg-green-600', no: 'bg-red-600') }} text-white font-bold">
    {{ $count }}
    {{ $voteType->value }}
</x-tag>
