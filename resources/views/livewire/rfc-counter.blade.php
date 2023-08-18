<x-tag class="{{ $voteType->class(yes: 'bg-agree', no: 'bg-disagree') }} text-white font-bold">
    {{ $count }}
    {{ $voteType->value }}
</x-tag>
