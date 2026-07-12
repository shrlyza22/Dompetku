@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-clay-400 dark:border-clay-600 text-start text-base font-bold text-clay-700 dark:text-clay-300 bg-clay-50 dark:bg-clay-900/30 focus:outline-none focus:text-clay-800 dark:focus:text-clay-200 focus:bg-clay-100 dark:focus:bg-clay-900 focus:border-clay-700 dark:focus:border-clay-300 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-stone-600 dark:text-stone-400 hover:text-stone-800 dark:hover:text-stone-200 hover:bg-clay-50/60 dark:hover:bg-stone-800 hover:border-clay-200 dark:hover:border-stone-600 focus:outline-none focus:text-stone-800 dark:focus:text-stone-200 focus:bg-clay-50/60 dark:focus:bg-stone-800 focus:border-clay-200 dark:focus:border-stone-600 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
