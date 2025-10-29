@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-vale-accent dark:focus:border-vale-accent focus:ring-vale-accent dark:focus:ring-vale-accent rounded-md shadow-sm']) !!}>