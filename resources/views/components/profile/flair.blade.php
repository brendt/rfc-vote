@if($user?->flair)
    <span
        aria-label="User role"
        class="text-xs border px-3 py-0.5 rounded-full mr-1.5 cursor-default"
        title="This user is {{ Str::title($user->flair->value) }}"
    >
        {{ Str::title($user->flair->value) }}
    </span>
@endif
