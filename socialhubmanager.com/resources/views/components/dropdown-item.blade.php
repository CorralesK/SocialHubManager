@props(['active' => false, 'disabled' => false])

@php
    $classes = 'block px-4 py-2 hover:bg-blue-100 hover:text-blue-800';

    if ($active) {
        $classes .= ' bg-blue-500 text-white';
    }

    if ($disabled) {
        $classes .= ' cursor-not-allowed opacity-50 pointer-events-none';
    }
@endphp

<li>
    <a {{ $attributes(['class' => $classes]) }}>
        {{ $slot }}
    </a>
</li>