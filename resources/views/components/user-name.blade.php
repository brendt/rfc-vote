@php
    /** @var \App\Models\User $user */
@endphp

<span class="flex items-center gap-2 relative group">
@if($user->getAvatarUrl())
    <img src="{{ $user->getAvatarUrl() }}" class="border-purple-200 border-2 rounded-full w-[30px] h-[30px]"/>
@endif
    {{ $user->name }} <x-user-popup :user="$user"/>
</span>
