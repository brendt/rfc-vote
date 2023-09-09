@if($user?->flair)
    <span
        aria-label="User role"
        class="text-xs border px-3 py-0.5 rounded-full mr-1.5 cursor-default text-font"
        data-tippy-content="{{ $user->flair->getDescription() }}"
    >
        {{ Str::title($user->flair->value) }}
    </span>
@endif
