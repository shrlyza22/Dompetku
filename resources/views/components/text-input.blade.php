@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-clay-200 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-300 focus:border-clay-500 dark:focus:border-clay-500 focus:ring-clay-500 dark:focus:ring-clay-500 rounded-lg shadow-sm']) }}>
