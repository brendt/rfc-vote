<div
    class="
            absolute left-1/2 -translate-x-1/2 border-r-transparent border-b-transparent border-[8px]
            border-{{ $argument->vote_type->getColor() }}-400
            @if ($argument->vote_type === \App\Models\VoteType::YES)
                -top-4
                rotate-45
            @else
                bottom-[-16px]
                rotate-[-135deg]
            @endif
          "
></div>
