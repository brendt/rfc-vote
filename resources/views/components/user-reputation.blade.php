@php
    /** @var \App\Models\User $user */
@endphp

<small
    class="
        p-1 px-2 rounded-full font-bold
        {{ match(true) {
            $user->reputation >= 5000 => 'bg-purple-800 text-white border-yellow-500 border-2',
            $user->reputation >= 2000 => 'bg-purple-800 text-white border-white border',
            $user->reputation >= 1000 => 'bg-purple-500 text-white border-white border',
            $user->reputation >= 500 => 'bg-purple-300 text-black border-black border',
            $user->reputation > 1 => 'bg-purple-200 text-black border-black border',
            default => 'bg-gray-200 text-black',
        } }}
    ">{{ $user->reputation }}</small>
