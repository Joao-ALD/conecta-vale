@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-vale-accent text-left text-base font-medium text-vale-accent bg-black/20 focus:outline-none focus:text-yellow-400 focus:bg-black/30 focus:border-yellow-600 transition duration-150 ease-in-out'
            : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-gray-200 hover:text-white hover:bg-black/20 focus:outline-none focus:text-white focus:bg-black/20 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>