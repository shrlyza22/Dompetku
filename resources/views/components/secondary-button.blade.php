<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white dark:bg-stone-800 border border-clay-200 dark:border-stone-600 rounded-full font-bold text-xs text-stone-700 dark:text-stone-300 uppercase tracking-widest shadow-sm hover:bg-clay-50 dark:hover:bg-stone-700 focus:outline-none focus:ring-2 focus:ring-clay-300 focus:ring-offset-2 dark:focus:ring-offset-stone-900 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
