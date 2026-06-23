@props([
    'src' => '',
    'alt' => '',
])

@php
    $placeholderSrc = asset('images/placeholder.svg');
@endphp

<img
    src="{{ $src }}"
    alt="{{ $alt }}"
    onerror="this.onerror=null;this.src='{{ $placeholderSrc }}';"
    {{ $attributes->merge() }}
>
