@php
    /** @var \App\Models\User $user */
@endphp

<span class="flex items-center gap-2">
{{ $user->name }} <x-user-reputation :user="$user"/>
</span>
