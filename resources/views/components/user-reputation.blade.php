@php
    /** @var \App\Models\User $user */
@endphp

<x-tag
    class="
        p-1 px-2 rounded-full font-bold
        {{ match(true) {
            $user->reputation >= 5000 => 'bg-purple-800 text-white ',
            $user->reputation >= 2000 => 'bg-purple-800 text-white',
            $user->reputation >= 1000 => 'bg-purple-500 text-white',
            $user->reputation >= 500 => 'bg-purple-300 text-black ',
            $user->reputation > 1 => 'bg-purple-200 text-black ',
            default => 'bg-gray-200 text-black',
        } }}
    ">{{ $user->reputation }}</x-tag>
