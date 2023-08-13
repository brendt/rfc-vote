<x-tag class="{{ $voteType->class(yes: 'bg-green-500', no: 'bg-red-500') }} text-white font-bold">
    {{ $count }}
    {{ $voteType->value }}
</x-tag>
