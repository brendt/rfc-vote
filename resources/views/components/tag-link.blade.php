@php
    $target = $attributes->get('target');
@endphp

<a href="{{ $href }}" {{ $target ? 'target="'.$target.'"' : '' }}>
    <x-tag {{ $attributes->except(['target']) }}>{{ $slot }}</x-tag>
</a>
