@props(['active' => false])

@php
    $classes = 'block px-4 py-2 hover:bg-blue-50 hover:text-blue-800';

    if ($active) {
        $classes .= ' bg-blue-500 text-white';
    }
@endphp

<li>
    <a {{ $attributes(['class' => $classes]) }}>
        {{ $slot }}
    </a>
</li>