@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-4 py-2 mx-0.5 rounded-full text-sm font-bold leading-5 bg-clay-500 text-white shadow-sm transition duration-150 ease-in-out'
            : 'inline-flex items-center px-4 py-2 mx-0.5 rounded-full text-sm font-semibold leading-5 text-stone-500 dark:text-stone-400 hover:text-clay-600 dark:hover:text-clay-300 hover:bg-clay-50 dark:hover:bg-stone-800 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
